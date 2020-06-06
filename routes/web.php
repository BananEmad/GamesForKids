<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/contact', function () {
    return view('website.contact');
});
Route::get('/about', function () {
    return view('website.about');
});
Route::get('/games', function () {
    return view('website.games');
});
Route::get('/news', function () {
    return view('website.news');
});

Route::get('/numbers',"Numbers\NumbersController@index");
Route::get('/numbersExam',"Numbers\NumbersController@exam");
Route::get('/numbersExamResult',"Numbers\NumbersController@result");

Auth::routes();

