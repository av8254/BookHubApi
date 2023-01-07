<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return Book::all(); //test
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required'
        ]);

        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return Book::find($id);

    }
    public function addBook(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $user = auth()->user();

        // Check if the user has already added the book
        $userBook = $user->books()->wherePivot('book_id', $id)->first();

        if ($userBook) {
            // The user has already added the book
            return response()->json([
                'error' => 'You have already added this book.',
            ], 400);
        } else {
            // Add the book to the user's account
            $user->books()->attach($id, ['status' => $validatedData['status']]);

            if ($request->has('rating')) {
                $user->ratings()->create([
                    'book_id' => $id,
                    'rating' => $request['rating'],
                    'comment' => $request['comment'],
                ]);
            }

            // Return a success response
            return response()->json([
                'message' => 'Book added to your account successfully.',
            ], 201);
        }
    }

    public function updateBook(Request $request, int $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        $user = auth()->user();

        $user->books()->updateExistingPivot($id, ['status' => $validatedData['status']]);

        return response()->json([
            'message' => 'Book updated successfully.',
        ], 200);
    }

    public function getReadingBooks()
    {
        $user = auth()->user();

        return $user->books()->wherePivot('status', 'Reading')->get();
//
//        return response()->json([
//            'data' => $readingBooks,
//        ], 200);
    }

    public function getToBeReadBooks()
    {
        $user = auth()->user();

        return $user->books()->wherePivot('status', 'To be read')->get();
    }

    public function removeBook(int $id)
    {
        $user = auth()->user();

        $user->books()->detach($id);

        return response()->json([
            'message' => 'Book removed from your account successfully.',
        ], 200);
    }

    public function get_ratings($id)
    {
        return Book::find($id)->ratings()->get();
    }
    public function get_collections($id)
    {
        return Book::find($id)->collections()->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        $result = Book::destroy($id);
        if($result == 1){
            return "Book " . $id . " deleted.";
        }
        else return "Error";
    }
    /**
     * Search for title
     *
     * @param  string $query
     * @return Response
     */
    public function search($query)
    {
        return Book::where('title', 'like' ,'%'.$query.'%')->orWhere('author','like','%'.$query.'%')->get();
        //return Book::where('title', 'like' , sprintf('%%%s%%', $title))->paginate(2);
    }


}
