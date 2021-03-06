<?php

/**
 * Auth routes
 */
Auth::routes();

/**
 * User routes
 */
Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
	Route::get('users', function () { 
		return App\User::where('id', '!=', \Auth::user()->id)->get();
	});
	Route::get('auth-user', function () {
		return \Auth::user();
	});
});

/**
 * Chat routes
 */
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', ['uses' => 'ChatController@index', 'as' => 'chat.index']);
	Route::group(['prefix' => 'api'], function () {
		Route::get('message/{id}', ['uses' => 'ChatController@getMessage', 'as' => 'chat.message']);
		Route::get('messages/{id}', ['uses' => 'ChatController@getMessages', 'as' => 'chat.messages']);
		Route::post('message', ['uses' => 'ChatController@postMessage', 'as' => 'chat.message.send']);
		Route::patch('message/{id}', ['uses' => 'ChatController@updateMessage', 'as' => 'chat.message.update']);
		Route::delete('message/{id}', ['uses' => 'ChatController@deleteMessage', 'as' => 'chat.message.delete']);
	});
});