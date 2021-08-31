<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\BookBorrowInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowedBookController extends Controller
{
    //
    public function index(Request $request)
    {
        $borrowInfo = BookBorrowInfo::query();
    
        $fields = ['status','borrowed_on'];

        foreach($fields as $field){
            if($request->has($field)){
                $bookInfo->where($field, $request->get($field));
            }
        }
        return response()->json([
            "success" => true,
            "message" => "borrowed books",
            "data" => $borrowInfo->with(['book', 'member.user'])->paginate(10)
        ], 200);
    }
    public function borrowBook(Request $request)
    {
        $bookInfo = new BookBorrowInfo();

        $bookInfo->member_id = $request->member_id;
        $bookInfo->book_id = $request->book_id;
        $bookInfo->borrowed_on = Carbon::now()->format('Y-m-d');
        $bookInfo->returned_on = Carbon::now()->format('Y-m-d');

        $bookInfo->save();

        return response()->json([
                    'success' => true,
                    'message' => 'book borrowed',
                    'data' => $bookInfo
                ]);

                
    }

    public function available_books()
    {
        $available = DB::table('books')->count();

        if ($available <= 0) {
            return response()->json(['message' => 'no book available']);
        }
        return response()->json(['message' => 'available books', 'books' => $available]);
    }

    public function borrowed_books()
    {
    }
}
