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
Auth::routes();
Route::get('/shareable/{id}', 'ShareableEditorController@index')->name('shareable-editor');

Route::middleware('auth')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/editor/{id}', 'EditorController@index')->name('editor');
    Route::post('/content', 'Api\ContentController@store')->name('content-create');
});