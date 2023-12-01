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


Route::prefix('blog')->group(function () {
    Route::get('/', 'BlogController@index');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', 'BlogController@dashboard')->name('blog_dashboard');
        Route::resource('blog-category', BlogCategoriesController::class);
        Route::resource('blog-article', BlogArticlesController::class);
        Route::post('blog-article-update', 'BlogArticlesController@updateArticle')->name('blog-article-update');
        Route::post('upload/article/image', 'BlogArticlesController@updateImage')->name('blog_article_upload_image');
        Route::post('blog-article-upload-image', 'BlogArticlesController@uploadImageCkeditor')->name('blog_article_uploa_image_tiny');
    });
});
