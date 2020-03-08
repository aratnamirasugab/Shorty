<?php

use Dotenv\Regex\Regex;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\RegularExpression;

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

Route::get('/:shortcode', 'LinkController@index');
Route::get('/:shortcode/stats', 'LinkController@show');
Route::post('/shorten', 'LinkController@store');
