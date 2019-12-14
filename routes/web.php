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

Route::resource('dasboard','DasboardController');

Route::get('users','UsersController@index')->name('users');
Route::get('users/datatable','UsersController@datatable');
Route::get('users/create','UsersController@create')->name('users.create');
Route::get('users/edit/{id}','UsersController@edit');
Route::post('users/update','UsersController@update')->name('users.update');
Route::post('users/store','UsersController@store')->name('users.store');
Route::post('users/delete','UsersController@delete')->name('users.delete');

Route::get('kelas','KelasController@index')->name('kelas');
Route::get('kelas/datatable','KelasController@datatable');
Route::post('kelas/add','KelasController@add')->name('kelas.add');
Route::post('kelas/update','KelasController@update')->name('kelas.update');
Route::post('kelas/delete','KelasController@delete')->name('kelas.delete');

Route::get('matapelajaran','MatapelajaranController@index')->name('matapelajaran');
Route::get('matapelajaran/datatable','MatapelajaranController@datatable');
Route::post('matapelajaran/add','MatapelajaranController@add')->name('matapelajaran.add');
Route::post('matapelajaran/update','MatapelajaranController@update')->name('matapelajaran.update');
Route::post('matapelajaran/delete','MatapelajaranController@delete')->name('matapelajaran.delete');

Route::get('raport','RaportController@index')->name('raport');
Route::get('raport/datatable','RaportController@datatable');
Route::post('raport/add','RaportController@add')->name('raport.add');
Route::post('raport/update','RaportController@update')->name('raport.update');
Route::post('raport/delete','RaportController@delete')->name('raport.delete');
