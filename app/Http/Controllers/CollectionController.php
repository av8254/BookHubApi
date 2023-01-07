<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectionController extends Controller
{
    public function index()
    {
        return Collection::all(); //test
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
            'name' => 'required'
        ]);

        $request['user_id'] = auth()->id();

        return Collection::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function user_collections()
    {
        return auth()->user()->collections()->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        $result = Collection::destroy($id);
        if($result == 1){
            return "Book " . $id . " deleted.";
        }
        else return "Error";
    }

}
