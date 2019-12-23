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
    return view('auth.login');
});
Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::resource('dasboard','DasboardController');

Route::middleware('auth:web')->group( function () {


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
Route::get('raport/datatabledetail/{semester}','RaportController@datatabledetail');
Route::get('raport/create','RaportController@create')->name('raport.create');
Route::get('raport/detail/{year}/{id}/{semester}','RaportController@detail');
Route::post('raport/add','RaportController@add')->name('raport.add');
Route::post('raport/update','RaportController@update')->name('raport.update');
Route::post('raport/delete','RaportController@delete')->name('raport.delete');
Route::post('raport/store','RaportController@store')->name('raport.store');
Route::post('raport/absensi','RaportController@absensi')->name('raport.absensi');
Route::get('raport/downloadPDF/{year}/{id}/{semester}','RaportController@downloadPDF');
});
