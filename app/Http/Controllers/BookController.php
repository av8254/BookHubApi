<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

    public function get_ratings($id)
    {
        return Book::find($id)->ratings()->get();
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
