<?php

use Illuminate\Support\Facades\Route;
use Modules\Socialevents\Http\Controllers\EvenCategoryController;
use Modules\Socialevents\Http\Controllers\EvenEventController;
use Modules\Socialevents\Http\Controllers\EvenEventTickeClientController;
use Modules\Socialevents\Http\Controllers\EvenEventTickePriceController;
use Modules\Socialevents\Http\Controllers\EvenLocalController;
use Modules\Socialevents\Http\Controllers\SocialeventsController;

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

Route::middleware(['auth', 'verified'])->prefix('socialevents')->group(function () {
    Route::get('/', 'SocialeventsController@index');

    Route::middleware(['middleware' => 'permission:even_categoria_listado'])->get('categories', [EvenCategoryController::class, 'index'])->name('even_categories_list');
    Route::middleware(['middleware' => 'permission:even_categoria_nuevo'])->get('categories/create', [EvenCategoryController::class, 'create'])->name('even_categoriess_create');
    Route::post('categories/store', [EvenCategoryController::class, 'store'])->name('even_categories_store');
    Route::middleware(['middleware' => 'permission:even_categoria_editar'])->get('categories/{id}/edit', [EvenCategoryController::class, 'edit'])->name('even_categories_editar');
    Route::post('categories/update', [EvenCategoryController::class, 'update'])->name('even_categories_update');
    Route::middleware(['middleware' => 'permission:even_categoria_eliminar'])->delete('categories/destroy/{id}', [EvenCategoryController::class, 'destroy'])->name('even_categories_destroy');

    Route::middleware(['middleware' => 'permission:even_local_listado'])->get('locales', [EvenLocalController::class, 'index'])->name('even_local_list');
    Route::middleware(['middleware' => 'permission:even_local_nuevo'])->get('locales/create', [EvenLocalController::class, 'create'])->name('even_local_create');
    Route::post('locales/store', [EvenLocalController::class, 'store'])->name('even_local_store');
    Route::middleware(['middleware' => 'permission:even_local_editar'])->get('locales/{id}/edit', [EvenLocalController::class, 'edit'])->name('even_local_editar');
    Route::post('locales/update', [EvenLocalController::class, 'update'])->name('even_local_update');
    Route::middleware(['middleware' => 'permission:even_local_eliminar'])->delete('locales/destroy/{id}', [EvenLocalController::class, 'destroy'])->name('even_local_destroy');

    Route::middleware(['middleware' => 'permission:even_evento_listado'])->get('events', [EvenEventController::class, 'index'])->name('even_eventos_list');
    Route::middleware(['middleware' => 'permission:even_evento_nuevo'])->get('events/create', [EvenEventController::class, 'create'])->name('even_eventos_create');
    Route::post('events/store', [EvenEventController::class, 'store'])->name('even_events_store');
    Route::middleware(['middleware' => 'permission:even_evento_editar'])->get('events/{id}/edit', [EvenEventController::class, 'edit'])->name('even_eventos_editar');
    Route::post('events/update', [EvenEventController::class, 'update'])->name('even_eventos_update');
    Route::middleware(['middleware' => 'permission:even_evento_eliminar'])->delete('events/destroy/{id}', [EvenEventController::class, 'destroy'])->name('even_eventos_destroy');
    Route::post('events/prices/tickets/store', [EvenEventTickePriceController::class, 'store'])->name('even_events_preices_ticket_store');
    Route::middleware(['middleware' => 'permission:even_ventas_listado'])->get('tickets', [EvenEventTickeClientController::class, 'index'])->name('even_tickets_listado');
});
