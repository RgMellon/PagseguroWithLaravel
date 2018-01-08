<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Pagseguro'], function () {
    Route::get('pagseguro-transparent', 'PagseguroController@getCode')->name('pg.getcode');
    Route::post('pagseguro-boleto', 'PagseguroController@boleto')->name('pg.boleto');
    Route::post('pagseguro-cartao', 'PagseguroController@cartaoRequest')->name('pg.cartao.request');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
     $request->user();
});
