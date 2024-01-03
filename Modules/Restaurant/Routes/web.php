<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurant\Http\Controllers\ResComandaController;
use Modules\Restaurant\Http\Controllers\ResMenuComandaController;
use Modules\Restaurant\Http\Controllers\ResMenuController;
use Modules\Restaurant\Http\Controllers\ResPresentationController;
use Modules\Restaurant\Http\Controllers\ResSaleController;

Route::middleware(['auth', 'verified'])->prefix('restaurant')->group(function () {

    Route::middleware(['middleware' => 'permission:res_comandas'])
        ->get('comandas', [ResComandaController::class, 'index'])
        ->name('res_comandas_list');

    Route::middleware(['middleware' => 'permission:res_comandas_nuevo'])
        ->get('comandas/create', [ResComandaController::class, 'create'])
        ->name('res_comandas_create');

    Route::middleware(['middleware' => 'permission:res_comandas_nuevo'])
        ->get('comandas/edit/{id}', [ResComandaController::class, 'edit'])
        ->name('res_comandas_edit');

    Route::middleware(['middleware' => 'permission:res_comandas'])
        ->get('presentations/category/{id}', [ResPresentationController::class, 'getByCategory'])
        ->name('res_presentation_by_cat_list');

    Route::post('comandas/store', [ResComandaController::class, 'store'])
        ->name('res_comandas_store');

    Route::post('comandas/update', [ResComandaController::class, 'update'])
        ->name('res_comandas_update');

    Route::delete('comandas/destroy/{id}', [ResComandaController::class, 'destroy'])
        ->name('res_comandas_destroy');

    Route::middleware(['middleware' => 'permission:res_menu'])
        ->get('menus', [ResMenuController::class, 'index'])
        ->name('res_menu_list');

    Route::middleware(['middleware' => 'permission:res_menu_nuevo'])
        ->get('menus/create', [ResMenuController::class, 'create'])
        ->name('res_menu_create');

    Route::middleware(['middleware' => 'permission:res_menu_verimprimir'])
        ->get('menus/show/{id}', [ResMenuController::class, 'show'])
        ->name('res_menus_show');


    Route::middleware(['middleware' => 'permission:res_menu_editar'])
        ->get('menus/edit/{id}', [ResMenuController::class, 'edit'])
        ->name('res_menus_edit');

    Route::post('menus/store', [ResMenuController::class, 'store'])
        ->name('res_menus_store');

    Route::put('menus/update/{id}', [ResMenuController::class, 'update'])
        ->name('res_menus_update');

    Route::delete('menus/destroy/{id}', [ResMenuController::class, 'destroy'])
        ->name('res_menus_destroy');

    Route::get('menus/comandas/all/{id}', [ResMenuComandaController::class, 'getComandas'])
        ->name('res_menus_comandas');

    Route::put('menus/comandas/store/{id}', [ResMenuComandaController::class, 'storeComandas'])
        ->name('res_menus_comandas_store');

    Route::middleware(['middleware' => 'permission:res_venta_nuevo'])
        ->get('sales/create', [ResSaleController::class, 'create'])
        ->name('res_sales_create');

    Route::middleware(['middleware' => 'permission:res_venta'])
        ->get('sales/list', [ResSaleController::class, 'index'])
        ->name('res_sales_list');

    Route::post('sale/store', [ResSaleController::class, 'store'])
        ->name('res_sales_store');
});
