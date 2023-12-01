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

Route::middleware(['auth', 'verified'])->prefix('onlineshop')->group(function () {
    Route::get('dashboard', 'OnlineshopController@index')->name('onlineshop_dashboard');
    Route::get('items', 'OnliItemController@index')->name('onlineshop_items');
    Route::get('items/create', 'OnliItemController@create')->name('onlineshop_items_create');
    Route::post('items/store', 'OnliItemController@store')->name('onlineshop_items_store');
    Route::get('items/edit/{id}', 'OnliItemController@edit')->name('onlineshop_items_edit');
    Route::post('items/update', 'OnliItemController@update')->name('onlineshop_items_update');
    Route::delete('items/destroy/{id}', 'OnliItemController@destroy')->name('onlineshop_items_destroy');
    Route::get('sales', 'OnliSaleController@index')->name('onlineshop_sales');
});

Route::get('mercadopago/preference/{id}', 'OnliSaleController@getPreference')->name('onlineshop_mercadopago_preference');
Route::post('client/account/store', 'OnliSaleController@store')->name('onlineshop_client_account_store');
Route::post('get/item', 'OnliItemController@getItemCarrito')->name('onlineshop_get_item_carrito');
