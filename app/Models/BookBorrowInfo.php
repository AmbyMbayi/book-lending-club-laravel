<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowInfo extends Model
{
    use HasFactory;


    protected $fillable = ['member_id', 'book_id', 'borrowed_on', 'returned_on', 'status'];

    protected $with=['member', 'book'];

    //protected $hidden = ['member', 'book'];

    //protected $appends = ['member_name', 'book_title'];

    
    public function getMemberNameAttribute(){
        return $this->member->name;
    
    }
    public function getBookTitleAttribute(){
        return $this->book->title;
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
