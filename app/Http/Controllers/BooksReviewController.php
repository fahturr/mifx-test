<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BooksReviewController extends Controller
{
    public function __construct()
    {
    }

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        $bookReview = new BookReview();

        $request->validated();

        $bookReview->review = $request->post('review');
        $bookReview->comment = $request->post('comment');

        $book = Book::findOrFail($bookId);
        $user = Auth::user();

        $bookReview->book()->associate($book->id);
        $bookReview->user()->associate($user->id);
        $bookReview->save();

        return new BookReviewResource($bookReview);
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $book = Book::findOrFail($bookId);

        $book->reviews()->findOrFail($reviewId)->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
