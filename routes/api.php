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

Route::middleware('auth:api')->get('/api/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->middleware(['auth:api'])->prefix('admin/api')->group(function () {
    Route::apiResource('conversation', 'ConversationsController');
    Route::apiResource('webchat-setting', 'WebchatSettingsController', ['except' => ['store', 'destroy']]);
    Route::apiResource('chatbot-user', 'ChatbotUsersController', ['except' => ['store', 'update', 'destroy']]);
    Route::apiResource('user', 'UsersController');

    Route::apiResource('outgoing-intents', 'OutgoingIntentsController');
    Route::apiResource('outgoing-intents/{id}/message-templates', 'MessageTemplatesController');

    Route::prefix('conversation/{id}')->group(function () {
        Route::get('/publish', 'ConversationsController@publish');
        Route::get('/unpublish', 'ConversationsController@unpublish');
    });

    Route::get('chatbot-user/{id}/messages', 'ChatbotUsersController@messages');
});
