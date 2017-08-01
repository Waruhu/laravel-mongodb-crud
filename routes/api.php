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

Route::get('articles/', 'ArticleController@index');
Route::get('articles/{id}', 'ArticleController@show');
Route::post('articles', 'ArticleController@store');
Route::put('articles/{id}', 'ArticleController@update');
Route::delete('articles/{id}', 'ArticleController@destroy');

Route::resource('members', 'MemberController');

Route::group(['middleware' => ['web']], function () {
    Route::get('/search', [
        'as' => 'api.search',
        'uses' => 'SearchController@search'
    ]);
    Route::get('searchajax',[
        'as'=>'api.searchajax',
        'uses'=>'SearchController@autoComplete'
    ]);
});