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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            //$table->unsignedBigInteger('user_id');
            //$table->unsignedBigInteger('article_id');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');                  //references('id')->on('users');
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');                                        //references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
