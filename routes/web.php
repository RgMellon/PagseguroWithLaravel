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
Route::group(['namespace' => 'Pagseguro'], function () {
    // Route::post('pagseguro-transparent', 'PagseguroController@getCode')->name('pg.getcode');
    Route::get('pagseguro-transparent', 'PagseguroController@transparent')->name('pg.transparent');
    Route::get('pagseguro', 'PagseguroController@pagseguro')->name('pagseguro');
    Route::get('pagseguro-cartao', 'PagseguroController@cartaoCredito')->name('pg.cartao');
});
