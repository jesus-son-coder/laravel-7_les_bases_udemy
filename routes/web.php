<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
    return view('main.home');
})->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Les Routes de connexions sont résumées avec cette seule instruction ci-dessous :
Auth::routes();

// Ci-dessous, on surcharge la route "logout" uniquement :
Route::get('/logout', function() {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');


