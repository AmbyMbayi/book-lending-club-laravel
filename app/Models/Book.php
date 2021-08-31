<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','copies', 'category_id', 'file_path'];

    protected $table = "books";

    protected $hidden = [ 'category'];

    protected $appends = [ 'category_name'];

    
    public function getCategoryNameAttribute(){
        return $this->category->name;
    
    }
    

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
