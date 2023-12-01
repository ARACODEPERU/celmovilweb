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
use Modules\Purchases\Http\Controllers\PurcDocumentController;

Route::middleware(['auth', 'verified'])->prefix('purchases')->group(function () {
    Route::get('/', 'PurchasesController@index');

    Route::get('documents', [PurcDocumentController::class, 'index'])->name('purc_documents_list');
    Route::get('documents/create', [PurcDocumentController::class, 'create'])->name('purc_documents_create');
    Route::post('documents/store', [PurcDocumentController::class, 'store'])->name('purc_documents_store');
});
