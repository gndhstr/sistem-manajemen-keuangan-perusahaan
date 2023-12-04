<?php

use Illuminate\Support\Facades\Auth; //class untuk Route
use Illuminate\Support\Facades\Route; //class untuk auth

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
    return redirect(route('login'));
});
Route::get('/starter', function () {
    return view('starter');
});

Auth::routes(['verify' => false, 'reset' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::prefix('direktur')->group(function () {
    Route::get('/dashboard', 'DirekturDashboardController@index');
}); //rute direktur sementara


Route::get('/user', 'tbl_userController@index')->name('daftarUser');
Route::get('/user/{user}/delete', 'tbl_userController@destroy')->name('deleteUser');

//Route view user