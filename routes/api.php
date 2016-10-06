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
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('hamburgers', ['as' => 'hamburgers_api', function () {
	return App\Hamburger::all();
}]
);
*/
Route::resource('hamburgers','HamburgerController',['only'=>['index','store','show','update']]);
Route::resource('hamburgers.descriptions','HamburgerDescriptionController',['only'=>['index','store','show','update','destroy']]);

