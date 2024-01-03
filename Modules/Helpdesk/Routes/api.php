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

Route::middleware('auth:sanctum')->prefix('helpdesk')->group(function () {
    Route::get('client/records',  'HelpdeskController@getRecords')->name('api_helpdesk_client_records');
    Route::get('client/themes/{id}/questions',  'HelpdeskController@getThemesQuestions')->name('api_helpdesk_client_themes_questions');
});
