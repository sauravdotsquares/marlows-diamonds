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
			// Post Category Routes
			Route::get('/posts/categories','PostCategoryController@index')->name('postcategories');
			Route::get('/posts/categories/create/{catslug?}','PostCategoryController@createForm')->name('create');
			Route::post('/posts/categories/add','PostCategoryController@add')->name('add');
			Route::post('/get-postcategories','PostCategoryController@getPostCategory')->name('get-postcategories');
			Route::post('/change-postcategories','PostCategoryController@status');
			Route::post('/delete-postcategories','PostCategoryController@delete');
			//Appreance>Menus Routes
			Route::get('/menus', 'MenuController@index')->name('menus');
			Route::post('/menus/save', 'MenuController@save');
			// Customer Users Routes
			Route::get('/users', 'UserController@index')->name('users');
			Route::get('/users/create', 'UserController@create')->name('create');
			Route::post('/users/add', 'UserController@add')->name('add');
			Route::get('/users/update/{id}', 'UserController@update')->name('create');
			Route::post('/users/edit/{id}', 'UserController@edit');
			Route::get('/delete-user/{id}', 'UserController@delete');
			Route::get('/users/status/{id}/{status}', 'UserController@status');
			// Product Category Routes
			Route::get('/products/categories','CategoryController@index')->name('categories');
			Route::get('/products/categories/create/{catslug?}','CategoryController@createForm')->name('create');
			Route::post('/products/categories/add','CategoryController@add')->name('add');
			Route::post('/get-categories','CategoryController@getCategory')->name('get-category');
			Route::post('/change-categories','CategoryController@status');
			Route::post('/delete-categories','CategoryController@delete');

			// Product Add Pages Routes
			Route::get('/products/products','ProductController@index')->name('products-list');
			Route::get('/products/create','ProductController@create')->name('products-createform');
			Route::get('/products/update/{prodid}','ProductController@updatePage')->name('products-updateform');
			Route::post('/products/change-product-status','ProductController@status')->name('change-product-status');
			Route::post('/products/delete-product-records','ProductController@delete')->name('delete-product-records');
			Route::post('/get-product-details-variation','ProductController@getProductDetailsVariation')->name('get-product-details-variation');

			Route::post('/products/submit-product','ProductController@submitProduct')->name('submit-product');
			Route::post('/products/add-attribute-data','ProductController@addAttribute')->name('add-attribute');
			Route::post('/products/get-attribute-data','ProductController@getAttribute')->name('get-attribute');
			
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
			// Enquiries
			Route::get('/enquiries', 'EnquiryController@index')->name('enquiries');
			Route::get('/enquiries/update/{id}', 'EnquiryController@update')->name('create');
			Route::post('/enquiries/edit/{id}', 'EnquiryController@edit');
			Route::get('/delete-enquiry/{id}', 'EnquiryController@delete');
			// Appointments
			Route::get('/appointments', 'AppointmentController@index')->name('appointments');
			Route::get('/appointments/update/{id}', 'AppointmentController@update')->name('create');
			Route::post('/appointments/edit/{id}', 'AppointmentController@edit');
			Route::get('/delete-appointment/{id}', 'AppointmentController@delete');
			// Popups Route
			Route::get('/popups', 'PopupController@index')->name('popups');
			Route::get('/popups/create', 'PopupController@create')->name('create');
			Route::post('/popups/add', 'PopupController@add')->name('add');
			Route::get('/popups/update/{id}', 'PopupController@update')->name('create');
			Route::post('/popups/edit/{id}', 'PopupController@edit');
			Route::get('/delete-popup/{id}', 'PopupController@delete');
			Route::get('/popups/status/{id}/{status}', 'PopupController@status');
			
			// Header Settings Route
			Route::get('/header-settings', 'SettingsController@headerSetting')->name('header-settings');
			Route::post('/header-settings-update', 'SettingsController@headerSettingUpdate');
			// Footer Settings Route
			Route::get('/footer-settings', 'SettingsController@footerSetting')->name('footer-settings');
			Route::post('/footer-settings-update', 'SettingsController@footerSettingUpdate');
			// Banner Route
			Route::get('/banners', 'BannerController@index')->name('banners');
			Route::get('/banners/create', 'BannerController@create')->name('create');
			Route::post('/banners/add', 'BannerController@add')->name('add');
			Route::get('/banners/update/{id}', 'BannerController@update')->name('create');
			Route::post('/banners/edit/{id}', 'BannerController@edit');
			Route::get('/delete-banner/{id}', 'BannerController@delete');
			Route::delete('/delete-banner-image/{id}', 'BannerController@deleteBannerImage');
			Route::get('/banners/status/{id}/{status}', 'BannerController@status');
		//});
	});
});

Auth::routes();

/*
*** Frontend Routes
*/

Route::namespace('Front')->group(function () {
    Route::get('/', 'PageController@page')->name('home');

    Route::get('/my-account', 'LoginController@index')->name('my-account');
    Route::post('/login-customer-account', 'LoginController@getLoginRegisterAccount')->name('login.customer.account');
	
	Route::get('repnetapi','ProductController@getNewRepNetFunction');
    Route::get('{page}', 'PageController@page')->name('page');
	Route::get('product-category/{cat1?}/{cat2?}/{cat3?}','ProductController@productCategory');
	Route::get('product/{slug?}','ProductController@productDetails');
	Route::post('product/get-product-list','ProductController@getProductList');
	Route::post('product/get-custom-filter','ProductController@getCustomFilter')->name('custom-filter');
	Route::post('product/get-products-video','ProductController@getProductVideo')->name('get-product-video');
	Route::post('product/custom-api-filter','ProductController@getCustomApiFilterData')->name('custom-api-filter-data');
	Route::post('post/get-data','PageController@myPost');
    Route::get('/blog-resources/{slug}', 'PageController@show');
	Route::post('/visit-us', 'ContactUsFormController@ContactUsForm')->name('contact');
	Route::post('/', 'MailListFormController@MailListForm')->name('maillist');
	// Route::get('{slug?}', 'UriController')->name('page_url')->where('slug','.+');


	Route::get('products/cart', 'AddToCartController@index')->name('product.cart');
	Route::post('product/add-to-cart/{id?}', 'AddToCartController@addToCart')->name('add.to.cart');
	Route::patch('product/update-cart', 'AddToCartController@updateCart')->name('update.cart');
	Route::delete('product/remove-from-cart', 'AddToCartController@removeCart')->name('remove.from.cart');
	
	Route::get('products/checkout', 'AddToCartController@checkoutOrder')->name('product.checkout');
	Route::get('products/wishlist', 'WishlistController@index')->name('products.wishlist');
	Route::post('product/set-product-wishlist/{slug?}', 'WishlistController@addToWishlist')->name('set-product-wishlist');
	Route::delete('product/remove-from-wishlist', 'WishlistController@removeWishlist')->name('remove.from.wishlist');

	Route::post('products/products-final-price','ProductPriceController@getProductFinalPrice')->name('products-final-price');
	
});

/*
*** Angular Routes Group
*/

Route::group(['prefix' => 'api/v1'], function() {
	Route::namespace('Api')->group(function () {
		Route::get('getDiamondDataFromAPI' , 'DiamondFinderController@diamondSearch');
	});
});

