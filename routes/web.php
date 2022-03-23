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
		//Route::group(['middleware' => ['role:admin|superadmin, guard:employee']], function () {
			Route::get('/', 'DashboardController@index')->name('dashboard');
			Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
			Route::get('/pages', 'PageController@index')->name('pages');
			Route::get('/pages/create', 'PageController@create')->name('create');
			Route::post('/pages/add', 'PageController@add')->name('add');
			Route::get('/pages/update/{id}', 'PageController@update')->name('create');
			Route::post('/pages/edit/{id}', 'PageController@edit');
			Route::get('/delete-page/{id}', 'PageController@delete');
			Route::get('/pages/status/{id}/{status}', 'PageController@status');
		// Posts
			Route::get('/posts', 'PostController@index')->name('posts');
			Route::get('/posts/create', 'PostController@create')->name('create');
			Route::post('/posts/add', 'PostController@add')->name('add');
			Route::get('/posts/update/{id}', 'PostController@update')->name('create');
			Route::post('/posts/edit/{id}', 'PostController@edit');
			Route::get('/delete-post/{id}', 'PostController@delete');
			Route::get('/posts/status/{id}/{status}', 'PostController@status');	
		//});
	});
});

Auth::routes();

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

});

