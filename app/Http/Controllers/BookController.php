<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Transformer\BookTransformer;
use League\Fractal\Resource\Item as Item;
use Leaque\Fractal;

use League\Fractal\Manager;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return fractal()->collection($books)->transformWith(new BookTransformer())->includeCharacters()->toArray();        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.bookadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book;
        $book->_id =  $request->input('id');
        $book->title =  $request->input('title');
        $book->isbn =  $request->input('isbn');
        $book->author =  $request->input('author');
        $book->category = $request->input('category') ;
        $book->save();
        $books = Book::all();
        return fractal()->collection($books)->transformWith(new BookTransformer())->includeCharacters()->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $book = Book::find($id);
      return fractal()->item($book, new BookTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $book = Book::find($id);
      return view('books.bookedit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $book = Book::find($id);
      $book->title = $request->input('title');
      $book->isbn = $request->input('isbn');
      $book->author = $request->input('author');
      $book->category = $request->input('category');
      $book->save();
      $books = Book::all();
      return fractal()->collection($books)->transformWith(new BookTransformer())->includeCharacters()->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $book = Book::find($id);
      $book->delete();
      $books = Book::all();
      return fractal()->collection($books)->transformWith(new BookTransformer())->includeCharacters()->toArray();
    }
}
