<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
         //$borrowInfo = BookBorrowInfo::with('member', 'book')->get();

        return response()->json([
            'success' => true,
            'message' => "categories",
            'data' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
             'name' => 'required',
           
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();


        return response()->json([
            'success' => true,
            'message'=> 'category created',
            'data' => $category
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
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                'message' => "category not found"
            ]);
        }

        return response()->json([
           'data' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'category deleted'
        ], 202);
    }


}
