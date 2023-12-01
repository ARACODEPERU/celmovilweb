<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Helpdesk\Http\Controllers\BoardController;
use Modules\Helpdesk\Http\Controllers\HelpLevelController;

Route::middleware('auth')->prefix('helpdesk')->group(function () {
    Route::get('monitoring', 'HelpdeskController@index')->name('helpdesk_monitoring');
    Route::resource('help-boards', BoardController::class);
    Route::resource('help-level', HelpLevelController::class);
    Route::post('helpleveluser/save',  'HelpLevelController@saveUser')->name('helpleveluser_save');
    Route::post('helpboardlevels/save',  'BoardController@saveLevels')->name('helpboardlevels_save');
    Route::delete('helpboardlevels/destroy/{id}',  'BoardController@saveLevels')->name('helpboardlevels_destroy');
});
