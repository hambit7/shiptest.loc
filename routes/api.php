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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'],function(){
    Route::resource('resources', 'ApiController');
//ships
    Route::resource('ships', 'ShipController');
    Route::post('changeShipStatus/{id}', 'ShipController@changeShipStatus');
//routes of ships
    Route::resource('routes', 'RouteController');
//containers
    Route::resource('containers', 'ContainerController');
//tracks
    Route::resource('tracks', 'TrackController');

    Route::post('addTracksToRoute', 'TrackController@addTracksToRoute');
});





