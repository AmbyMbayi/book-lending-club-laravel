<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('copies');
            $table->unsignedBigInteger('category_id')->index();
            $table->string('file_path');
   
            $table->timestamps();
        });
        Schema::table('books', function(Blueprint $table){
            $table->foreign('category_id')->references('id')->on('categories');
        });
     
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
