<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::all();
        if (is_null($books)) {
            return response()->json([
                'message' => "books not found"
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => "Books list",
            'data' => $books
        ], 200); 

       

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'copies' => 'required',
            'category_id' => 'required',
           'file_path'=> 'mimes:jpeg,png,jpg'
          
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $book =new Book;
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->copies = $request->input('copies');
        $book->category_id = $request->input('category_id');
        $book->file_path = $request->file('file_path')->store('images');

      
       // $book = Book::create($request->only(['title', 'description', 'copies','category_id', 'file_path'=> $image_path]));
      
       
       $book->save();
       $book->load('category');

        return response()->json([
            'success' => true,
            'message'=> 'book created',
            'data' => $book
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return response()->json([
                'message' => "book not found"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "book retrived",
            'data' => $book
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'copies' => 'required',
        
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $book->title = $input['title'];
        $book->description = $input['description'];
        $book->copies = $input['copies'];
        $book->save();

        return response()->json([
            'success' => true,
            'message' => 'Book update successful',
            'data' => $book
        ]);
    }


    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message' => 'Book deleted'
        ], 202);
    }

   
}
