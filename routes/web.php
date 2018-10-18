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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'HomeController@index')->name('admin');

Route::group(['middleware'=>['auth'],'prefix'=>'admin'],function(){  
    
    //reservaciones
    Route::get('/reservaciones/nueva', 'Reservaciones\ReservacionController@create')->name('reservaciones.new');
    Route::get('/reservaciones', 'Reservaciones\ReservacionController@index')->name('reservaciones.index');
    Route::get('/reservaciones/editar/{id?}', 'Reservaciones\ReservacionController@edit')->name('reservaciones.edit');
    Route::post('/reservaciones/editar', 'Reservaciones\ReservacionController@modification')->name('reservaciones.modification');    
    Route::get('/reservaciones/eliminar/{id?}', 'Reservaciones\ReservacionController@remove')->name('reservaciones.remove');    
    Route::put('/reservaciones/validate', 'Reservaciones\ReservacionController@validateAjax')->name('reservaciones.validateAjax');
    Route::post('/reservaciones/store', 'Reservaciones\ReservacionController@store')->name('reservaciones.store'); 
    
    //usuarios
    Route::get('/usuarios', 'Users\UserController@index')->name('users.index');
    Route::get('/usuarios/nuevo', 'Users\UserController@create')->name('users.new');
    Route::get('/usuarios/editar/{id?}', 'Users\UserController@edit')->name('users.edit');
    Route::get('/usuarios/eliminar/{id?}', 'Users\UserController@remove')->name('users.remove');
    Route::post('/usuarios/nuevo', 'Users\UserController@store')->name('users.store'); 
    Route::post('/usuarios/editar', 'Users\UserController@modific')->name('users.modific'); 
    
});


