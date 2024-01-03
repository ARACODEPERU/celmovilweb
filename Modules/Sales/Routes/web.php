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

use App\Http\Controllers\LocalSaleController;
use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\PettyCashController;
use Modules\Sales\Http\Controllers\ProductController;
use Modules\Sales\Http\Controllers\ProviderController;
use Modules\Sales\Http\Controllers\ReportController;
use Modules\Sales\Http\Controllers\SaleController;
use Modules\Sales\Http\Controllers\SaleDocumentController;
use Modules\Sales\Http\Controllers\SaleLowCommunicationController;
use Modules\Sales\Http\Controllers\SalePhysicalDocumentController;
use Modules\Sales\Http\Controllers\SaleProductBrandController;
use Modules\Sales\Http\Controllers\SaleProductCategoryController;
use Modules\Sales\Http\Controllers\SaleSummaryController;
use Modules\Sales\Http\Controllers\SerieController;

Route::middleware(['auth', 'verified'])->prefix('sales')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('pettycash', PettyCashController::class);
    Route::resource('providers', ProviderController::class);

    Route::get('service/create', [ProductController::class, 'createService'])->name('create_service');
    Route::post('service/store', [ProductController::class, 'storeService'])->name('store_service');

    Route::post('petty/cash/close/{petty_id}', [PettyCashController::class, 'close_petty'])->name('close_petty_cash');

    Route::post('petty/cash/expense/store', [PettyCashController::class, 'store_expense'])->name('store_expense');

    Route::resource('sales', SaleController::class);

    Route::get('pdf/sales/ticket/{id}', [SaleController::class, 'ticketPdf'])->name('ticketpdf_sales');

    Route::post('search/products', [ProductController::class, 'searchProduct'])->name('search_product');

    Route::post('search/products/all', [ProductController::class, 'searchProductAll'])->name('search_product_all');

    Route::post('get/product/local/', [ProductController::class, 'getProductByLocal'])->name('get_product_by_local');

    Route::post('search/scaner/products', [ProductController::class, 'searchScanerProduct'])->name('search_scaner_product');

    Route::post('show/detail_product', [ProductController::class, 'showDetailProduct'])->name('show_detail_product');

    Route::post('showdetails/products/{id}', [ProductController::class, 'showdetails'])->name('showdetails');

    Route::post('input/products', [ProductController::class, 'saveInput'])->name('input_products');

    Route::post('local/series', [LocalSaleController::class, 'series'])->name('localseriesbyid');

    Route::get('get/locals', [LocalSaleController::class, 'get_locals'])->name('get_locals');

    Route::resource('series', SerieController::class);

    Route::get('reports/list', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/sales/by/dates/{start?}/{end?}/{local_id?}/{consulta?}', [ReportController::class, 'sales_report_dates'])->name('sales_report_dates');

    Route::post('upload/image/product', [ProductController::class, 'imageUpload'])->name('product_upload_image');

    Route::post('prices/product/bylocal', [ProductController::class, 'savePrices'])->name('product_prices_establishments');

    Route::get('prices/product/{id}', [ProductController::class, 'getPricesProduct'])->name('product_prices');
    Route::get('reports/saleindate', [ReportController::class, 'sales_report'])->name('sale_report');
    Route::get('reports/pettycash/{petty_cash_id}/report', [ReportController::class, 'PettyCashReport'])->name('PettyCashReport');

    Route::get('reports/inventoryindate', [ReportController::class, 'inventory_report_export'])->name('inventory_report');

    Route::get('reports/inventory/{local_id}', [ReportController::class, 'inventory_report_by_local'])->name('inventory_report_by_local');

    Route::get('reports/sales/{begin_date}/{end_date}/{download}', [ReportController::class, 'sales_report_export'])->name('sales_report_export');

    Route::get('print/sales/user/{date}', [SaleController::class, 'printSalesDay'])->name('print_sale_user');

    Route::post('relocate/product/sizes', [ProductController::class, 'saveRelocate'])->name('relocate_product_sizes');

    Route::get('reports/payment/method/motals', [ReportController::class, 'reportPaymentMethodTotals'])->name('report_payment_method_totals');

    Route::post('data/payment/method/motals', [ReportController::class, 'dataPaymentMethodTotals'])->name('data_payment_method_totals');

    Route::post('import/product/data', [ProductController::class, 'import'])->name('import_product_data');



    Route::get('sale_document_series/{id}', [SaleDocumentController::class, 'getSerieByDocumentType'])->name('sale_document_series');

    ///rutas de docuemntos de ventas boletas y facturas
    Route::get('saledocuments', [SaleDocumentController::class, 'create'])->name('saledocuments_create');
    Route::post('saledocuments/store', [SaleDocumentController::class, 'store'])->name('saledocuments_store');
    Route::post('saledocuments/store_from_ticket', [SaleDocumentController::class, 'storeFromTicket'])->name('saledocuments_store_from_ticket');
    Route::get('saledocuments/list', [SaleDocumentController::class, 'index'])->name('saledocuments_list');
    Route::get('saledocuments/send/{id}/{type}', [SaleDocumentController::class, 'sendSunatDocument'])->name('saledocuments_send');
    Route::post('saledocuments/update/details', [SaleDocumentController::class, 'updateDetailsAndHeader'])->name('saledocuments_update_details');
    Route::get('saledocuments/create/fromticket/{id}', [SaleDocumentController::class, 'createFromFicket'])->name('saledocuments_create_from_ticket');
    Route::get('saledocuments/download/{id}/{type}/{file}', [SaleDocumentController::class, 'printDocument'])->name('saledocuments_download');
    Route::post('saledocuments/update/head', [SaleDocumentController::class, 'updateHead'])->name('saledocuments_update_head');

    ////rutas de resumen diario
    Route::get('salesummary/list', [SaleSummaryController::class, 'index'])->name('salesummaries_list');
    Route::get('salesummary/search/{date}', [SaleSummaryController::class, 'searchDocuments'])->name('salesummaries_search_date');
    Route::post('salesummary/store', [SaleSummaryController::class, 'store'])->name('salesummaries_store_date');
    Route::get('salesummary/check/{id}/{ticket}', [SaleSummaryController::class, 'checkSummary'])->name('salesummaries_store_check');
    Route::get('salesummary/destroy/{id}', [SaleSummaryController::class, 'destroySummary'])->name('salesummaries_destroy');

    ////rutas de comunicacion de baja
    Route::get('lowcommunication/list', [SaleLowCommunicationController::class, 'index'])->name('low_communication_list');
    Route::get('lowcommunication/search/{date}', [SaleLowCommunicationController::class, 'searchDocuments'])->name('low_communication_search_date');
    Route::post('lowcommunication/store', [SaleLowCommunicationController::class, 'store'])->name('low_communication_store');
    Route::get('lowcommunication/check/{id}/{ticket}', [SaleLowCommunicationController::class, 'check'])->name('low_communication_check');
    Route::get('lowcommunication/destroy/{id}', [SaleLowCommunicationController::class, 'destroy'])->name('low_communication_destroy');


    ///////////nuevo cambios en productos
    Route::post('category/products/store', [SaleProductCategoryController::class, 'store'])->name('sale_category_product_store');

    Route::post('brand/products/store', [SaleProductBrandController::class, 'store'])->name('sale_brand_product_store');


    ///////documentos fisico o de otra plataforma
    Route::get('physicaldocument/list', [SalePhysicalDocumentController::class, 'index'])->name('sale_physical_document_list');
    Route::get('physicaldocument/create', [SalePhysicalDocumentController::class, 'create'])->name('sale_physical_document_create');
    Route::post('physicaldocument/store', [SalePhysicalDocumentController::class, 'store'])->name('sale_physical_document_store');
    Route::delete('physicaldocument/destroy/{id}', [SalePhysicalDocumentController::class, 'destroy'])->name('sale_physical_document_destroy');
});
