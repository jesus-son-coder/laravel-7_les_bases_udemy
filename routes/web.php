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

// Page d'accueil principale :
// ---------------------------
Route::get('/', 'MainController@home')->name('main.home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Les Routes de connexions sont résumées avec cette seule instruction ci-dessous :
Auth::routes();

// Ci-dessous, on surcharge la route "logout" uniquement :
Route::get('/logout', function() {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');


// ----------------------------------------------
// Affichage (d'un) des Cours (Vue Utilisateur) :
// ----------------------------------------------
Route::get('/courses', 'CoursesController@courses')->name('courses.index');
Route::get('/courses/{slug}', 'CoursesController@course')->name('courses.show');



// ------------------------------------------
// Administration des Cours (dans la Vue Formateur) :
// ------------------------------------------
Route::get('/instructor/overview', 'InstructorController@index')->name('instructor.index');
Route::get('/instructor/new', 'InstructorController@create')->name('instructor.create');
Route::post('/instructor/store', 'InstructorController@store')->name('instructor.store');
Route::get('/instructor/courses/{id}/edit', 'InstructorController@edit')->name('instructor.edit');
Route::put('/instructor/courses/{id}/update', 'InstructorController@update')->name('instructor.update');
Route::get('/instructor/courses/{id}/delete', 'InstructorController@destroy')->name('instructor.delete');

// --------------------------
// Mise en ligne d'un Cours :
// --------------------------
Route::get('/instructor/courses/{id}/publish', 'InstructorController@publish')->name('instructor.publish');


// -------------------------
// Pricing et Tarification :
// -------------------------
Route::get('/instructor/courses/{id}/pricing', 'PricingController@pricing')->name('pricing.index');
Route::post('/instructor/courses/{id}/pricing/store', 'PricingController@store')->name('pricing.store');


// ---------------------------
// Sections et Plans de Cours:
// ---------------------------
Route::get('/instructor/courses/{id}/curriculum', 'CurriculumController@index')->name('instructor.curriculum.index');
Route::get('/instructor/courses/{id}/curriculum/new', 'CurriculumController@create')->name('instructor.curriculum.create');
Route::post('/instructor/courses/{id}/curriculum/store', 'CurriculumController@store')->name('instructor.curriculum.store');
Route::get('/instructor/courses/{id}/curriculum/{sectionId}/edit', 'CurriculumController@edit')->name('instructor.curriculum.edit');
Route::put('/instructor/courses/{id}/curriculum/{sectionId}/update', 'CurriculumController@update')->name('instructor.curriculum.update');
Route::get('/instructor/courses/{id}/curriculum/{sectionId}/delete', 'CurriculumController@destroy')->name('instructor.curriculum.delete');


// ---------------------------
// Gestion du Panier d'achat :
// ---------------------------
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::get('/cart/store/{id}', 'CartController@store')->name('cart.store');
Route::get('/cart/delete/{id}', 'CartController@delete')->name('cart.delete');
Route::get('/cart/clear', 'CartController@clear')->name('cart.clear');


// ---------------------------
// La WishList :
// ---------------------------
Route::get('/wishlist/store/{id}', 'WishListController@store')->name('wishlist.store');
Route::get('/wishlist/delete/{id}', 'WishListController@destroy')->name('wishlist.destroy');
