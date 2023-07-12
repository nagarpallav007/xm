<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/stock/form', 'App\Http\Controllers\StockController@showForm')->name('form');
Route::post('/stock/submit', 'App\Http\Controllers\StockController@submitForm')->name('submit');
Route::get('/stock/symbols', 'App\Http\Controllers\StockController@fetchSymbols')->name('symbols');

