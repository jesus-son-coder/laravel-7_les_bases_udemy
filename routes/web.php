<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('my_route');

// Route::get('/new', [ArticleController::class, 'create'])->middleware('auth');
Route::get('/new', [ArticleController::class, 'create']);

// Route::post('/store', 'ArticleController@store')->middleware('auth')->name('article.store');
Route::post('/store', 'ArticleController@store')->name('article.store');

Route::get('/failure', function(){
    return view('components.failure');
})->name('failure');
