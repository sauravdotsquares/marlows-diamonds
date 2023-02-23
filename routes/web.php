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
// use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\UrlRedirects;
use Illuminate\Http\Request;

Route::get('/clear-cache', function() {
	Artisan::call('cache:clear');
	// Artisan::call('config:cache');
	// Artisan::call('route:cache');
	// Artisan::call('view:clear');
	echo 'Application cache cleared';
});

/**
 * Admin routes
 */
Route::get('/phpinfo', function() {
    return phpinfo();
});
Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'admin','middleware' => ['employee'], 'as' => 'admin.'], function () {

	Route::namespace('Admin')->group(function () {

		//Route::group(['middleware' => ['role:superadmin|admin']], function () {
		Route::get('/', 'DashboardController@index')->name('dashboard');
		Route::any('/uploadEditorImage', 'PostController@uploadEditorImage')->name('uploadEditorImage');
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

		//Appreance > Menus Routes
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
		Route::any('/products/update-price/{slug}','ProductController@productPricing')->name('product-pricing');
		Route::any('/products/get-product-price','ProductController@getProductPricing')->name('get-product-price');
		Route::any('/products/images/{slug}','ProductController@uploadFiles')->name('update_product_images');
		

		

		Route::post('/products/change-product-status','ProductController@status')->name('change-product-status');
		Route::post('/products/delete-product-records','ProductController@delete')->name('delete-product-records');
		Route::post('/get-product-details-variation','ProductController@getProductDetailsVariation')->name('get-product-details-variation');

		Route::post('/delete-product-variation','ProductController@deleteProductVariation')->name('delete-product-variation');

		Route::post('/products/submit-product','ProductController@submitProduct')->name('submit-product');
		Route::post('/products/add-attribute-data','ProductController@addAttribute')->name('add-attribute');
		Route::post('/products/get-attribute-data','ProductController@getAttribute')->name('get-attribute');
		Route::post('/products/remove-product-images','ProductController@removeProductImages')->name('remove-product-images');
		Route::get('/products/base-price-list','ProductController@basePriceList')->name('base-price-list');
		Route::get('/products/export-base-price','ProductController@basePriceexportCsv')->name('export-base-price');
		Route::any('/products/update-base-price','ProductController@basePriceUpdate')->name('update-base-price');
		Route::get('/products/search','ProductController@productSearch')->name('product-search');
		
		

		// Faqs Route list
		Route::get('/faqs', 'FaqController@index')->name('faqs');
		Route::get('/faqs/create', 'FaqController@create')->name('create');
		Route::post('/faqs/add', 'FaqController@add')->name('add');
		Route::get('/faqs/update/{id}', 'FaqController@update')->name('create');
		Route::post('/faqs/edit/{id}', 'FaqController@edit');
		Route::get('/delete-faq/{id}', 'FaqController@delete');
		Route::get('/faqs/status/{id}/{status}', 'FaqController@status');
		// Faq Category Routes
		Route::get('/faqcategories', 'FaqCategoryController@index')->name('faqcategories');
		Route::get('/faqcategories/create', 'FaqCategoryController@create')->name('createfaqcategories');
		Route::post('/faqcategories/add', 'FaqCategoryController@add')->name('add');
		Route::get('/faqcategories/update/{id}', 'FaqCategoryController@update')->name('create');
		Route::post('/faqcategories/edit/{id}', 'FaqCategoryController@edit');
		Route::get('/delete-faqcategories/{id}', 'FaqCategoryController@delete');
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

		Route::get('orders/orders-details-page','OrderController@index')->name('order.details.page');
		Route::post('orders/change-order-status','OrderController@changeOrderStatus')->name('order.change.order.status');
		Route::get('orders/order-product-details/{orderId}','OrderController@orderProductDetails')->name('order.product.details');
		//});
		Route::get('get-harikrishna-data','HariKrishnaController@index');
		Route::get('instagram-post', 'InstagramController@updateInstaData')->name('instagram-post');
		Route::get('instagram-api-post', 'InstagramController@index')->name('instagram');

		Route::get('get-product-excel-report','ProductController@getProductExcelReport')->name('get-product-report');

		Route::get('discount','DiscountController@index')->name('discount');
		Route::get('discount/creatediscount','DiscountController@addDiscount')->name('create-discount');
		Route::post('creatediscount','DiscountController@addDiscountData')->name('create-discount-form');
		Route::get('edit-discount/{disId}','DiscountController@editPageDiscountData')->name('edit-discount');
		Route::post('/change-discount','DiscountController@status');
		Route::post('/delete-discount','DiscountController@delete');

		Route::get('xmlpage','XMLController@XMLFunction')->name('xml-page');

		/* Sitemap Route*/
		// Route::get('/sitemap', 'SitemapController@sitemapFunction')->name('sitemap');

		Route::group(['as' => 'masters.', 'prefix' => 'masters' ], function () {
			Route::any('/{type}', 'MastersController@index')->name('index');
			Route::any('/add/{type}', 'MastersController@add')->name('add');
			Route::any('/edit/{type}/{slug}', 'MastersController@edit')->name('edit');
			Route::any('/status/{type}/{slug}', 'MastersController@status')->name('status');
			Route::any('/delete/{type}/{slug}', 'MastersController@delete')->name('delete');
		});


		// Route::group(['as' => 'lab_price_variations.', 'prefix' => 'lab_price_variations' ], function () {
		// 	Route::any('/', 'ProductController@labPriceList')->name('list');
		// 	Route::any('/change-status/{id}', 'ProductController@labPriceChangeStatus')->name('change_status');
		// 	Route::any('/delete/{id}', 'ProductController@labPriceDelete')->name('delete');
		// 	Route::any('/add', 'ProductController@labPriceAdd')->name('add');
		// 	Route::any('/edit/{id}', 'ProductController@labPriceEdit')->name('edit');
		// });

		Route::group(['as' => 'product_combinations.', 'prefix' => 'product_combinations' ], function () {
			Route::any('', 'GlobalCombinationsController@index')->name('index');
			Route::any('/add', 'GlobalCombinationsController@add')->name('add');
			Route::any('/edit/{slug}', 'GlobalCombinationsController@edit')->name('edit');
			Route::any('/status/{slug}', 'GlobalCombinationsController@status')->name('status');
			Route::any('/view/{slug}', 'GlobalCombinationsController@view')->name('view');
		});

		Route::group(['as' => 'combinations.', 'prefix' => 'combinations', 'namespace' =>'Products' ], function () {
			Route::any('', 'CombinationsController@index')->name('index');
			Route::any('/add-attributes', 'CombinationsController@addAttributes')->name('add_attributes');
			Route::any('/add-varitions/{slug}', 'CombinationsController@addVariations')->name('add_varitions');
		});

		Route::group(['as' => 'app_products.', 'prefix' => 'app-products', 'namespace' =>'Products' ], function () {
			
			Route::any('/', 'AppProductsController@list')->name('list');
			Route::any('/basic-information', 'AppProductsController@basicInformation')->name('basic_information');
			Route::any('/basic-information/{slug}', 'AppProductsController@editBasicInformation')->name('edit_basic_information');
			
			Route::any('/variations/{slug}', 'AppProductsController@variationsSelection')->name('variations');
			Route::any('/variations-edit/{slug}', 'AppProductsController@variationsSelectionEdit')->name('variations_edit');
			
			Route::any('/upload-images', 'AppProductsController@uploadImages')->name('upload_images');
			Route::any('/remove-images', 'AppProductsController@removeImage')->name('remove_images');

			Route::any('/change-status/{slug}', 'AppProductsController@changeStatus')->name('change_status');
			Route::any('/delete/{slug}', 'AppProductsController@deleteRecord')->name('delete');
			
			
			// Route::any('/images/{slug}', 'AppProductsController@addImages')->name('add_images');
			// Route::any('/edit/{slug}', 'AppProductsController@edit')->name('edit');
			// Route::any('/attributes/{slug}', 'AppProductsController@addAttributes')->name('add_attributes');
			// Route::any('/variations/{slug}', 'AppProductsController@addVariations')->name('add_variations');
			// Route::any('/get-categories', 'AppProductsController@getCategories')->name('get_categories');

		});


		Route::group(['as' => 'image_gallery.', 'prefix' => 'image_gallery' ], function () {
			Route::any('', 'ImageGalleryController@index')->name('index');
			Route::any('/add', 'ImageGalleryController@add')->name('add');
			Route::any('/upload-file', 'ImageGalleryController@uploadImages')->name('uploadImages');
			Route::any('/remove-file', 'ImageGalleryController@removeImage')->name('removeImage');
			Route::any('/delete/{id}', 'ImageGalleryController@deleteFile')->name('deleteFile');
			Route::any('/files-list', 'ImageGalleryController@getFilesList')->name('getFilesList');
			Route::any('/use-media', 'ImageGalleryController@useImage')->name('useImage');
			
		});


		Route::group(['as' => 'lab_price_variations.', 'prefix' => 'products/lab-price-variants' ], function () {
			// Route::any('', 'LabPricesListController@index')->name('list');
			Route::any('/', 'LabPricesListController@labPriceList')->name('list');
			Route::any('/change-status/{id}', 'LabPricesListController@labPriceChangeStatus')->name('change_status');
			Route::any('/delete/{id}', 'LabPricesListController@labPriceDelete')->name('delete');
			Route::any('/add', 'LabPricesListController@labPriceAdd')->name('add');
			Route::any('/edit/{id}', 'LabPricesListController@labPriceEdit')->name('edit');
		});


		Route::group(['as' => 'seo_scripts.', 'prefix' => 'seo-scripts' ], function () {
			Route::any('/', 'SeoScriptsController@list')->name('list');
			Route::any('/add', 'SeoScriptsController@add')->name('add');
			Route::any('/edit/{id}', 'SeoScriptsController@edit')->name('edit');
			Route::any('/change-status/{id}', 'SeoScriptsController@changeStatus')->name('change_status');
			Route::any('/delete/{id}', 'SeoScriptsController@delete')->name('delete');
			Route::any('/view/{id}', 'SeoScriptsController@view')->name('view');
		});



	});


});

Auth::routes();

/*
*** Frontend Routes
*/

Route::group(['middleware' => ['customer']], function () {
	Route::namespace('Front')->group(function() {
		Route::get('/my-accounts', 'LoginController@dashboardPage')->name('my_accounts');
		Route::get('/logout-customer', 'LoginController@logout')->name('logout-customer');
		// Route::post('/place-order', 'PlaceOrderController@placeOrder')->name('place.order');
		Route::get('products/checkout/dekopay/{orderId?}', 'DekoPayController@receipt_page')->name('make.dekopay');

	});
});

// ->middleware(['SiteMapSaver'])
Route::namespace('Front')->middleware(['SiteMapSaver'])->group(function () {

    Route::get('/', 'PageController@page')->name('home');


	Route::get('hk-data-fetch', 'ApiController@getHariKrishnaFunction');

	/** Change after SEO discuss 05Jan2023 seo_change */
	Route::get('/blog/{slug}', 'PageController@show');
	Route::get('/blog/category/{slug}', 'PageController@blogList')->name('blog_list');
	Route::get('product/{slug?}','ProductController@productDetails')->name('product.details');

	/** generate sitemap */
	Route::get('sitemap.xml', 'ProductController@generateSitemap')->name('sitemap');
	Route::get('sitemap', 'ProductController@htmlSiteMap')->name('htmlSiteMap');

	/** Route use to redirect blog-resources to blog */
	Route::get('/blog-resources/{any?}',function(){
		$redirectTo = pageRedirects(request()->path());
		if(!empty($redirectTo)){
			return redirect($redirectTo, 301);
		}
		$url = str_replace("blog-resources","blog",request()->path());
		return redirect('/'. $url, 301);
	})->where('any', '.*');

	Route::any('product-listing-data','ProductController@productListingData');
	/** Change slugs of all products from previous to new one */

	Route::get('redirects','ProductController@productSlugs');
	
	// Route::get('product-slugs','ProductController@productSlugs');

	/** Change slugs of all products from previous to new one */
	// Route::get('product-slugs-update','ProductController@productSlugs');

	Route::post('/place-order', 'PlaceOrderController@placeOrder')->name('place.order');
    Route::get('/my-account', 'LoginController@index')->name('my-account');
    Route::post('/register-customers', 'LoginController@registerCustomer')->name('register-customers');
    Route::post('/login-customers', 'LoginController@loginCustomer')->name('login-customers');

    Route::post('/login-customer-account', 'LoginController@getLoginRegisterAccount')->name('login.customer.account');

    Route::post('/check-email-id', 'LoginController@checkEmailId')->name('check.email.id');

	Route::get('repnetapi','ProductController@getNewRepNetFunction');
	//Route::any('/exclusive', 'ProductController@exclusiveMarlows')->name('products.exclusive');

	// Route::any('{slug}','ProductController@productListPage');

	Route::get('product-category/{cat1?}/{cat2?}/{cat3?}','ProductController@productCategory');
	

	//Route::post('product/{slug?}','ContactUsFormController@ContactUsForm')->name('contact');
	Route::post('product/get-product-list','ProductController@getProductList');

	Route::post('product/get-related-product-list','ProductController@getRelatedProductList')->name('get.related.product.list');
	

	Route::post('product/get-custom-filter','ProductController@getCustomFilter')->name('custom-filter');
	Route::any('product/get-variations-data','ProductController@getSelectedVariationsData')->name('get-variations-data');

	Route::post('product/get-products-video','ProductController@getProductVideo')->name('get-product-video');
	Route::post('product/custom-api-filter','ProductController@getCustomApiFilterData')->name('custom-api-filter-data');
	Route::any('product-api/custom-api-filter','ProductController@getCustomApiFilterData')->name('custom-api-filter-data-api');
	Route::post('post/get-data','PageController@myPost');
    // Route::get('/blog-resources/{slug}', 'PageController@show');
	Route::post('/visit-us', 'ContactUsFormController@ContactUsForm')->name('contact');
	Route::post('/', 'MailListFormController@MailListForm')->name('maillist');
	// Route::get('{slug?}', 'UriController')->name('page_url')->where('slug','.+');

 
	Route::get('products/cart', 'AddToCartController@index')->name('product.cart');
	Route::post('product/add-to-cart', 'AddToCartController@addToCart')->name('add.to.cart');
	Route::post('product/add-to-cart-diamond', 'AddToCartController@addToCartDiamond')->name('add.to.cart.diamond');
	Route::patch('product/update-cart', 'AddToCartController@updateCart')->name('update.cart');
	Route::delete('product/remove-from-cart', 'AddToCartController@removeCart')->name('remove.from.cart');

	Route::get('products/checkout', 'AddToCartController@checkoutOrder')->name('product.checkout');
	Route::get('products/wishlist', 'WishlistController@index')->name('products.wishlist');
	Route::post('product/set-product-wishlist/{slug?}', 'WishlistController@addToWishlist')->name('set-product-wishlist');
	Route::delete('product/remove-from-wishlist', 'WishlistController@removeWishlist')->name('remove.from.wishlist');

	Route::post('products/products-final-price','ProductPriceController@getProductFinalPrice')->name('products-final-price');

	Route::post('products/products-final-price-with-diamond','ProductPriceController@getProductFinalPriceWithDiamond')->name('products-final-price-with-diamond');

	Route::get('products/handle-payment/{order_id?}', 'PayPalPaymentController@handlePayment')->name('make.payment');
	Route::get('products/cancel-payment', 'PayPalPaymentController@paymentCancel')->name('cancel.payment');
	Route::get('products/payment-success', 'PayPalPaymentController@paymentSuccess')->name('success.payment');

	Route::post('users/customer-user-address','LoginController@changeCustomerUserAddress')->name('users.customer.address');
	Route::post('users/update-customer-account-details','LoginController@changeCustomerAccountDetails')->name('update.customer.account.details');

	Route::post('users/get-order-details','LoginController@getOrderDetails')->name('get.order.details');
	Route::post('users/get-order-details-page','LoginController@getOrderDetailsPage')->name('get.order.details.pages');
	/*
	*** Reset Password
	*/
	Route::get('/users/forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
	Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
	Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
	Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

	Route::get('search/autocomplete','ProductController@autocomplete')->name('autocomplete');

	Route::post('download-pdf','HomeController@downloadPDF')->name('download-pdf');
	Route::get('deko-api/dekopay', 'DekoPayController@check_response');


	Route::get('deko-api/dekopay', 'DekoPayController@check_response');


	
	
	

	// {slug2?}/{slug3?}
	Route::get('{page}', 'PageController@page')->name('page');
	Route::group(['as' => 'app_products.', 'prefix' => 'p' ], function () {

		Route::any('/detail/{product_slug}', 'AppProductsController@productDetails')->name('details');
		Route::any('/price', 'AppProductsController@getVariationPrice')->name('price');
		Route::any('/{category_slug}', 'AppProductsController@getProductList')->name('list');

		// Route::any('/details/{slug}', 'AppProductsController@getProductDetails')->name('details');
		// Route::any('/customfilter', 'AppProductsController@getCustomFilter')->name('customfilter');
		// Route::any('/customfilternew', 'AppProductsController@getCustomFilterNew')->name('customfilternew');
		// Route::any('/varitiondata', 'AppProductsController@getSelectedVariationsData')->name('varitiondata');
		// Route::post('product/get-custom-filter','ProductController@getCustomFilter')->name('custom-filter');
		// Route::any('/add', 'GlobalCombinationsController@add')->name('add');
		// Route::any('/edit/{slug}', 'GlobalCombinationsController@edit')->name('edit');
		// Route::any('/status/{slug}', 'GlobalCombinationsController@status')->name('status');
		// Route::any('/view/{slug}', 'GlobalCombinationsController@view')->name('view');
	});

	Route::group(['as' => 'wishlist.', 'prefix' => 'w' ], function () {
		Route::any('/add', 'AppWishListController@addToWishList')->name('wishlist_add');
	});

});

/*
*** Angular Routes Group
*/
Route::group(['prefix' => 'api/v1'], function() {
	Route::namespace('Api')->group(function () {
		Route::get('getDiamondDataFromAPI' , 'DiamondFinderController@diamondSearch');
		Route::post('getProductCatFilter' , 'ProductController@filters');
		Route::post('searchProducts','ProductController@searchProducts');
	});
});

