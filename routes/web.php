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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'admin','middleware' => ['employee'], 'as' => 'admin.'], function () {
	Route::namespace('Admin')->group(function () {
		//Route::group(['middleware' => ['role:superadmin|admin']], function () {
			Route::get('/', 'DashboardController@index')->name('dashboard');
			Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
			// Change Password Routes
			Route::get('/change-password', 'PasswordController@index')->name('change-password');
			Route::post('/change-password', 'PasswordController@changePassword');
			// Settings Route
			Route::get('/settings', 'SettingsController@index');
			Route::post('/settings-update', 'SettingsController@update');
			// Pages Route
			Route::get('/pages', 'PageController@index')->name('pages');
			Route::get('/pages/create', 'PageController@create')->name('create');
			Route::post('/pages/add', 'PageController@add')->name('add');
			Route::get('/pages/update/{id}', 'PageController@update')->name('create');
			Route::post('/pages/edit/{id}', 'PageController@edit');
			Route::get('/delete-page/{id}', 'PageController@delete');
			Route::get('/pages/status/{id}/{status}', 'PageController@status');
			// Blog/Posts Routes
			Route::get('/posts', 'PostController@index')->name('posts');
			Route::get('/posts/create', 'PostController@create')->name('create');
			Route::post('/posts/add', 'PostController@add')->name('add');
			Route::get('/posts/update/{id}', 'PostController@update')->name('create');
			Route::post('/posts/edit/{id}', 'PostController@edit');
			Route::get('/delete-post/{id}', 'PostController@delete');
			Route::get('/posts/status/{id}/{status}', 'PostController@status');	
			//Appreance>Menus Routes
			Route::get('/menus', 'MenuController@index')->name('menus');
			Route::post('/menus/save', 'MenuController@save');
			// Customer Users Routes
			Route::get('/users','UserController@index')->name('users');
			Route::post('/users','UserController@store');
			Route::post('/change-record','UserController@status');
			Route::post('/delete-record','UserController@delete');
			// Product Category Routes
			Route::get('/products/categories','CategoryController@index')->name('categories');
			Route::get('/products/categories/create/{catid?}','CategoryController@createForm')->name('create');
			Route::post('/products/categories/add','CategoryController@add')->name('add');
			Route::post('/get-categories','CategoryController@getCategory')->name('get-category');
			Route::post('/change-categories','CategoryController@status');
			Route::post('/delete-categories','CategoryController@delete');

			// Product Add Pages Routes

			// Faqs Route
			Route::get('/faqs', 'FaqController@index')->name('faqs');
			Route::get('/faqs/create', 'FaqController@create')->name('create');
			Route::post('/faqs/add', 'FaqController@add')->name('add');
			Route::get('/faqs/update/{id}', 'FaqController@update')->name('create');
			Route::post('/faqs/edit/{id}', 'FaqController@edit');
			Route::get('/delete-faq/{id}', 'FaqController@delete');
			Route::get('/faqs/status/{id}/{status}', 'FaqController@status');
			// Reviews Route
			Route::get('/reviews', 'ReviewController@index')->name('faqs');
			Route::get('/reviews/create', 'ReviewController@create')->name('create');
			Route::post('/reviews/add', 'ReviewController@add')->name('add');
			Route::get('/reviews/update/{id}', 'ReviewController@update')->name('create');
			Route::post('/reviews/edit/{id}', 'ReviewController@edit');
			Route::get('/delete-review/{id}', 'ReviewController@delete');
			Route::get('/reviews/status/{id}/{status}', 'ReviewController@status');
		//});
	});
});

Auth::routes();

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

});

