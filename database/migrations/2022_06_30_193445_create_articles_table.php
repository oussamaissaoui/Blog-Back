<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');

           // $table->unsignedBigInteger('user_id');
            //$table->unsignedBigInteger('author_id');
           
            $table->text('body');
            $table->string('image')->nullable();


            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
