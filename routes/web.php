<?php

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
});

Auth::routes();


Route::middleware(['auth'])->group(function()
{

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('categories','categoriescontroller');
    Route::resource('posts','postcontroller');
    Route::resource('tags','tagscontroller');
    Route::get('trashed-posts','postcontroller@trashed')->name('trashed-posts.index') ;
    Route::put('restore-post/{post}','postcontroller@restore')->name('restore-posts');

});
Route::middleware(['auth','admin'])->group(function ()
{
    Route::get('users/profile','userscontroller@edit')->name('users.edit-profile');
    Route::put('users/profile','userscontroller@update')->name('users.update-profile');
    Route::get('users','userscontroller@index')->name('users.index');
    Route::post('users/{user}/make-admin','userscontroller@makeAdmin')->name('users.make-admin');
});