<?php

/**
 * Auth routes
 */
Auth::routes();

/**
 * User routes
 */
Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
	Route::get('users', function() { 
		return App\User::where('id', '!=', \Auth::user()->id)->get();
	});
});

/**
 * Chat routes
 */
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', ['uses' => 'ChatController@index', 'as' => 'chat.index']);
	Route::group(['prefix' => 'api'], function () {
		Route::get('sender', ['uses' => 'ChatController@getSender', 'as' => 'chat.sender']);
		Route::get('receiver', ['uses' => 'ChatController@getReceiver', 'as' => 'chat.receiver']);
		Route::get('sender-messages', ['uses' => 'ChatController@getSenderMessages', 'as' => 'chat.sender.messages']);
		Route::get('receiver-messages', ['uses' => 'ChatController@getReceiverMessages', 'as' => 'chat.receiver.messages']);
		Route::post('message', ['uses' => 'ChatController@postMessages', 'as' => 'chat.message.send']);
		Route::patch('message', ['uses' => 'ChatController@patchMessages', 'as' => 'chat.message.update']);
		Route::delete('message', ['uses' => 'ChatController@deleteMessages', 'as' => 'chat.message.delete']);
	});
});