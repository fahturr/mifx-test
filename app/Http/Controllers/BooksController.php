<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // @TODO implement
        $books = Book::paginate();

        $page = $request->query('page');
        $sortColumn = $request->query('sortColumn');
        $sortDirection = $request->query('sortDirection');
        $title = $request->query('title');
        $authors = $request->query('authors');

        return BookResource::collection($books);
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();
        
        $book->isbn = $request->post('isbn');
        $book->title = $request->post('title');
        $book->description = $request->post('description');
        $book->authors = $request->post('authors');
        $book->published_year = $request->post('published_year');
        
        $validated = $request->validated();

        $book->save();

        // return new BookResource($book);
        return response()->json(['message' => 'ayam goreng']);
    }
}
