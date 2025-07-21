<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', function () { return view('welcome'); });
    Route::get('about', 'PagesController@about');
    Route::get('privacy', 'PagesController@privacy');
    Route::get('history', 'PagesController@history');
    Route::get('board', 'PagesController@board');
    Route::get('team', 'PagesController@team');
    Route::get('terms', 'PagesController@terms');
    Route::get('finances', 'PagesController@finances');

    Route::get('contact', ['as' => 'contact', 'uses' => 'ContactController@getIndex']);
	Route::post('contact', ['as' => 'contact_store', 'uses' => 'ContactController@postStore']);

    Route::get('/home', 'HomeController@index');
});
