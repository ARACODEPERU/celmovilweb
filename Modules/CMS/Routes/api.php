<?php

use Illuminate\Http\Request;
use Modules\CMS\Http\Controllers\CMSController;
use Modules\CMS\Http\Controllers\CmsSectionItemController;
use Modules\CMS\Http\Controllers\CmsSubscriberController;

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

Route::middleware('auth:api')->get('/cms', function (Request $request) {
    return $request->user();
});

Route::prefix('cms_v1')->group(function () {
    Route::post('subscriber', [CmsSubscriberController::class, 'apiStore'])->name('apisubscriber');
    Route::get('page/all_data/{id}', [CMSController::class, 'apiGetPageData']);
    Route::get('section/group/all_data/{id}', [CMSController::class, 'apiGetSectionGroupData']);
});
