<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BooksController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        // @TODO implement
        $books = Book::with('authors');

        if ($request->has('authors')) {
            $listAuthorId = explode(',', $request->query('authors'));

            $books->whereHas('authors', function ($query) use ($listAuthorId) {
                return $query->whereIn('id', $listAuthorId);
            });
        }

        if ($request->has('title'))
            $books->where('title', 'like', '%' . $request->query('title') . '%');

        if ($request->has('sortColumn')) {
            $direction = '';

            if ($request->has('sortDirection')) {
                $direction = strtolower($request->query('sortDirection'));
            } else {
                $direction = 'asc';
            }
            
            if ($request->query('sortColumn') == 'avg_review') {
                $books->withCount(['reviews as r' => function ($query) {
                    $query->select(DB::raw('review/count(review)'));
                }])->orderBy('r', $direction);
            } else {
                $books->orderBy($request->query('sortColumn'), $direction);
            }

            // $books->orderBy($request->query('sortColumn'), $direction == '' ? 'asc' : $direction);
        }

        return BookResource::collection($books->paginate(15));
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();

        $request->validated();

        $book->isbn = $request->post('isbn');
        $book->title = $request->post('title');
        $book->description = $request->post('description');
        $book->published_year = $request->post('published_year');
        $book->save();

        foreach ($request->post('authors') as $idAuthors) {
            try {
                $book->authors()->attach($idAuthors);
            } catch (\Illuminate\Database\QueryException $e) {
                throw ValidationException::withMessages(['authors.0' => 'error']);
            }
        }

        return new BookResource($book);
    }
}
