<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('articles.index');
});

// Resource Route for Article
Route::resource('articles', ArticleController::class);
