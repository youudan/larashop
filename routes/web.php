<?php

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

Route::get('/', function(){
    return view('auth.login');
});

Auth::routes();

Route::match(['GET', 'POST'], '/register', function(){
    return redirect('/login');
})->name('register');

Route::get('/home', 'HomeController@index')->name('home');
// User
Route::get('users/setting', 'UserController@setting')->name('users.setting');
Route::put('users/setting_update', 'UserController@updateSetting')->name('users.update-setting');
Route::get('users/password', 'UserController@password')->name('users.password');
Route::put('users/password_update', 'UserController@updatePassword')->name('users.update-password');
Route::resource('users', 'UserController');
// Categories
Route::get('categories/trash', 'CategoryController@trash')->name('categories.trash');
Route::get('categories/{category}/restore', 'CategoryController@restore')->name('categories.restore');
Route::delete('categories/{category}/delete-permanent', 'CategoryController@deletePermanent')->name('categories.delete-permanent');
Route::resource('categories', 'CategoryController');
// Books
Route::get('books/trash', 'BookController@trash')->name('books.trash');
Route::get('books/{category}/restore', 'BookController@restore')->name('books.restore');
Route::delete('books/{category}/delete-permanent', 'BookController@deletePermanent')->name('books.delete-permanent');
Route::resource('books', 'BookController');
// Order
Route::resource('orders', 'OrderController');
// Ajax
Route::get('ajax/categories/search', 'CategoryController@ajaxSearch')->name('ajax.categories.search');