<?php


use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\KenthaController;
use App\Http\Controllers\CapperuController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\LocalSaleController;
use App\Http\Controllers\ParametersController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Mail\StudentRegistrationMailable;
use Illuminate\Support\Facades\Mail;
use Modules\Blog\Http\Controllers\BlogController;

// SITE WEB //
Route::get('/', [WebController::class, 'index'])->name('cms_principal');
Route::get('/inicio', [WebController::class, 'index'])->name('web_inicio');
Route::get('/nosotros', [WebController::class, 'nosotros'])->name('web_nosotros');

// SUPPORT
Route::get('/politicas-de-privacidad', [WebController::class, 'politicasprivacidad'])->name('web_politicas_de_privacidad');
Route::get('/preguntas-frecuentes', [WebController::class, 'preguntas'])->name('web_preguntas_frecuentes');
Route::get('/libro-de-reclamaciones', [WebController::class, 'claims'])->name('web_claims');

// STORE //
Route::get('/producto-descripcion/{id}/in', [WebController::class, 'productodescripcion'])->name('web_producto_descripcion');
Route::get('/producto-categoria/{id}/list', [WebController::class, 'productocategoria'])->name('web_producto_categoria');
Route::get('/productos/{id}/list', [WebController::class, 'productoPrincipal'])->name('web_producto_principal');
Route::get('/carrito', [WebController::class, 'carrito'])->name('web_carrito');
Route::post('/pagar', [WebController::class, 'pagar'])->name('web_pagar');
Route::put('/process_payment/{id}', [WebController::class, 'processPayment'])->name('web_process_payment');
Route::get('/gracias-compra/{id}', [WebController::class, 'graciasCompra'])->name('web_gracias_por_comprar_tu_entrada');
Route::get('/error-compra/{id}', [WebController::class, 'errorCompra'])->name('web_error_al_comprar');

// BLOG //
Route::get('/blog/home', [BlogController::class, 'index'])->name('blog_principal');
Route::get('/article/{url}', [BlogController::class, 'article'])->name('blog_article_by_url');
Route::get('/category/{id}', [BlogController::class, 'category'])->name('blog_category');
Route::get('/policies', [BlogController::class, 'policies'])->name('blog_policies');
Route::get('/contact-us', [BlogController::class, 'contactUs'])->name('blog_contact_us');
Route::get('/stories/article/{url}', [BlogController::class, 'storiesArticle'])->name('blog_stories_article_by_url');
Route::get('/stories/policies', [BlogController::class, 'storiesPolicies'])->name('blog_stories_policies');
Route::get('/stories/contact-us', [BlogController::class, 'storiesContactUs'])->name('blog_stories_contact_us');

Route::get('cookies_policy', function () {
    return view('cookies_policy');
})->name('cookies_policy');

// E-MAIL //
Route::get('/e-libro-de-reclamaciones', [WebController::class, 'eclaims'])->name('web_e_claims');
Route::get('/email', function () {
    Mail::to('elrodriguez2423@gmail.com')
        ->send(new StudentRegistrationMailable('data'));
    return 'mensaje enviado';
});


// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('users', UserController::class);
    Route::resource('establishments', LocalSaleController::class);

    Route::delete('establishments/destroies/{id}', [LocalSaleController::class, 'destroy'])->name('establishment_destroies');
    Route::post('establishments/updated', [LocalSaleController::class, 'update'])->name('establishment_updated');

    Route::get(
        'inventory/product/establishment',
        [KardexController::class, 'index']
    )->name('kardex_index');

    Route::post(
        'inventory/product/sizes',
        [KardexController::class, 'kardexDeailsSises']
    )->name('kardex_sizes');

    Route::post(
        'search/person/number',
        [PersonController::class, 'searchByNumberType']
    )->name('search_person_number');

    Route::post(
        'save/person/update/create',
        [PersonController::class, 'saveUpdateOrCreate']
    )->name('save_person_update_create');

    Route::post(
        'search/person/full_name/number',
        [PersonController::class, 'searchByNameOrNumber']
    )->name('search_person_fullname_number');

    Route::get(
        'general/stock',
        [KardexController::class, 'generalStock']
    )->name('generalstock');



    Route::get(
        'company/show',
        [CompanyController::class, 'show']
    )->name('company_show');

    Route::post(
        'company/update_create',
        [CompanyController::class, 'updateCreate']
    )->name('company_update_create');

    Route::get(
        'company/getdata',
        [CompanyController::class, 'getdata']
    )->middleware(['auth', 'verified'])->name('datosempresa');

    Route::get('parameters/list', [ParametersController::class, 'index'])->name('parameters');
    Route::get('parameters/create', [ParametersController::class, 'create'])->name('parameters_create');
    Route::post('parameters/store', [ParametersController::class, 'store'])->name('parameters_store');
    Route::get('parameters/{id}/edit', [ParametersController::class, 'edit'])->name('parameters_edit');
    Route::put('parameters/update/{id}', [ParametersController::class, 'update'])->name('parameters_update');
    Route::get('parameters/{id}/{val}/default', [ParametersController::class, 'updateDefaultValue'])->name('parameters_update_default_value');
});

require __DIR__ . '/auth.php';
