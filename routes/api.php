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

Route::group(['middleware' => 'auth:api'], function () {

    /*****************************************
     ------------ API VERSION #1 -------------
     *****************************************/
    Route::group(['prefix'=>'v1'],function (){
        /*************************************
         ------- API DE APP PASEADOR ---------
         ************************************/
        Route::group(['middleware' => 'auth_api_rol:paseador','prefix'=>'paseador'],function (){
            Route::group(['prefix'=>'cita'],function () {
                Route::post('get-agenda-fecha', 'Api\V1\AppPaseador\CitaController@getAgendaFecha');
            });
        });
        /*************************************
         ------- API DE APP DOGCAT QR ---------
         ************************************/
        Route::group(['middleware' => 'auth_api_rol:entidad','prefix'=>'dogcat-qr'],function (){
            Route::group(['prefix'=>'afiliado'],function () {
                Route::post('data', 'Api\V1\DogcatQR\AfiliadoController@data');
            });
        });
    });


});
