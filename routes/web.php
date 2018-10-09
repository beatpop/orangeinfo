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

Route::group(['namespace' => 'Index', 'middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/file/list', 'FileController@index');
    Route::get('/file/upload', 'FileController@showUpload');
    Route::post('/file/upload', 'FileController@upload');
    Route::get('/file/show/{id}', 'FileController@show');
    Route::get('/file/delete/{id}', 'FileController@delete');
});
