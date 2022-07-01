<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::middleware('auth:sanctum')->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/getUser','getUser');
        Route::post('/logout','logout');
        
    });

    Route::controller(ArticleController::class)->group(function(){
        
        //Articles Routes
        Route::post('/addArticle','addArticle');
        Route::get('/getAllArticles','getAllArticles');
        Route::get('/getOneArticle/{id}','getOneArticle');

        //Authors Routes
        Route::get('/getAuthorList','getAuthorList');

        //Comments Routes 
        Route::post('/addComment/{id}','addComment');
        Route::post('/deleteComment/{id}','deleteComment');
    });
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/login','login');
});
