<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


Route::get('/', function () {
    return view('welcome');
});

// روش 1: فقط این دو متد عمومی بدون میدل ور امنیت هستند
Route::resource('articles', ArticleController::class)->only(['index', 'show']);
Route::resource('articles', ArticleController::class)->only(['create', 'edit' , "store" , "destroy"])->middleware('auth');

