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

// Route::get('/', function () {
//     return view('welcome');
// });

    Auth::routes();

  Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();
Route::get('/', 'IndexController@index')->name('index');
//tour filter
Route::match(['get','post'],'/service-filter','ServicesController@filter');


//category listing page
Route::get('/serve/{CategoryName}','ServicesController@Serve');

//tour detail page
Route::get('/service/{id}','ServicesController@services');

//cart page
Route::match(['get','post'],'/cart', 'ServicesController@cart');

//add to cart
Route::match(['get','post'],'/add-cart', 'ServicesController@addtocart')->name('add-cart');

//delete service from cart
Route::get('/cart/delete-service/{id}', 'ServicesController@deleteCartPackage');

//Servicetype Price
Route::get('/get-service-Price','ServicesController@getServicePrice');

//Update Quantity in Cart
Route::get('/cart/update-quantity/{id}/{quantity}','ServicesController@UpdateCartQuantity');

 //wishlist page
 Route::match(['get','post'],'/wishlist', 'ServicesController@wishlist');

//Apply Coupon
Route::post('/cart/apply-coupon', 'ServicesController@applyCoupon');

//feedback
Route::get('/feedback','ServicesController@getfeedback');


//delete service from wishlist
Route::get('/wishlist/delete-service/{id}', 'ServicesController@deletewishlistPackage');


Route::get('/get-transport-Cost','ServicesController@getTransportCost');






Route::get('/login', 'UsersController@ShowLoginForm');
Route::post('/login', 'UsersController@login')->name('login');
Route::get('/logout', 'UsersController@logout');
Route::match(['get','post'],'forgot-password','UsersController@forgotpassword');


Route::get('/register', 'UsersController@showRegistrationForm')->name('register');
Route::post('/register', 'UsersController@register');

//Cornfirm Email account
Route::get('/confirm/{code}', 'UsersController@confirmAccount');
//Search Tour
Route::post('/search-service', 'ServicesController@searchServe');
//check-subscriber-email
Route::post('/check-subscriber-email','NewsletterController@checkSubscriber');
//add-subscriber-email
Route::post('/add-subscriber-email','NewsletterController@addSubscriber');





Route::get('admin/login', 'AdminLoginController@ShowLoginForm');
Route::post('admin/login', 'AdminLoginController@login');
Route::get('admin/logout', 'AdminController@logout');
Route::match(['get','post'],'admin-forgot-password','AdminController@forgotpassword');


Route::group(['prefix' => 'admin', 'middleware' => ['adminlogin']], function() {

    Route::get('/dashboard', 'AdminController@dashboard');
    Route::get('/settings', 'AdminController@settings')->name('admin.settings');
    Route::get('/check-pwd', 'AdminController@chkpassword');
    Route::match(['get','post'],'/update-pwd', 'AdminController@updatepassword');

    Route::get('/view-users-chart', 'UsersController@viewUsersChart');
    //category route
    Route::match(['get','post'],'/add-category', 'CategoryController@addCategory')->name('admin.add-category');
    Route::get('/view-categories', 'CategoryController@viewCategories');
    Route::match(['get','post'],'/edit-category/{id}', 'CategoryController@editCategory')->name('admin.edit-category');
    Route::match(['get','post'],'/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::get('/delete-category-image/{id}', 'CategoryController@deleteCategoryImage');

    //service route
    Route::match(['get','post'],'/add-service', 'ServicesController@addservice')->name('admin.add-service');
    Route::get('/view_services', 'ServicesController@viewService');
    Route::match(['get','post'],'/edit-service/{id}', 'ServicesController@editService')->name('admin.edit-service');
    Route::get('/delete-service/{id}', 'ServicesController@deleteService');
    Route::get('/delete-service-image/{id}', 'ServicesController@deleteServiceImage');


    //Servicetype
    Route::match(['get','post'],'/add-Servicetype/{id}', 'ServicesController@Servicetype')->name('admin.add-Servicetype');
    Route::match(['get','post'],'/edit-Servicetype/{id}', 'ServicesController@editservicetype')->name('admin.edit-Servicetype');
    Route::get('/delete-Servicetype/{id}', 'ServicesController@deleteTourtype');
    // Alternative Image
    Route::match(['get','post'],'/add-image/{id}', 'ServicesController@image')->name('admin.add-image');
    Route::get('/delete-alt-image/{id}', 'ServicesController@deleteAltimage');

    //tour-include
    Route::match(['get','post'],'/add-include/{id}', 'ServicesController@tourinclude')->name('admin.add-include');
    Route::get('/delete-tourinclude/{id}', 'ServicesController@deleteTourinclude');

    //tour transport
    Route::match(['get','post'],'/add-tourtransportation/{id}', 'ServicesController@transport')->name('admin.add-tourtransportation');
    Route::match(['get','post'],'/edit-tourtransportation/{id}', 'ServicesController@edittransport')->name('admin.edit-tourtransportation');
    Route::get('/delete-transport/{id}', 'ServicesController@deleteTransport');

    //tour accommodation
    Route::match(['get','post'],'/add-accommodation/{id}', 'ServicesController@accommodation')->name('admin.add-accommodation');
    Route::get('/delete-accommodation/{id}', 'ServicesController@deleteAccommodation');

    //coupon forms
    Route::match(['get','post'],'/add-coupon', 'CouponsController@addCoupon')->name('admin.add-coupon');
    Route::match(['get','post'],'/edit-coupon/{id}', 'CouponsController@editCoupon')->name('admin.edit-coupon');
    Route::get('/view-coupons','CouponsController@viewCoupons');
    Route::get('/delete-coupon/{id}', 'CouponsController@deleteCoupon');

    //banner route
    Route::match(['get','post'],'/add-banner', 'BannerController@addbanner')->name('admin.add-banner');
    Route::match(['get','post'],'/edit-banner/{id}', 'BannerController@editbanner')->name('admin.edit-banner');
    Route::get('/view-banners','BannerController@viewbanners');
    Route::get('/delete-banner/{id}', 'BannerController@deletebanner');

    //Admin Bookings Route
    Route::get('/view-bookings', 'ServicesController@viewBookings');
    //Admin Order Booking Detail Route
    Route::get('/view-bookings/{id}', 'ServicesController@viewBookingDetails');

    //Booking Invoice
    Route::get('/view-invoice/{id}', 'ServicesController@viewBookingInvoice');
    //Booking Invoice
    Route::get('/view-pdf/{id}', 'ServicesController@viewPDFInvoice');
    //Update Booking Status
    Route::post('/update-booking-status','ServicesController@updateBookingStatus');

    //Admin Users Route
    Route::get('/view-users', 'UsersController@viewUsers');
    //Users chart
    Route::get('/view-users-chart', 'UsersController@viewUsersChart');
    //Booking chart
    Route::get('/view-bookings-chart', 'ServicesController@viewBookingsChart');
    //Booking chart
    Route::get('/view-users-countries-chart', 'UsersController@viewUsersCountriesChart');
    //Admin/Sub-Admins Route
    Route::get('/view-admins', 'AdminController@viewAdmins');
    //add Admin/Sub-Admins Route
    Route::match(['get','post'], '/add-admin', 'AdminController@addAdmin')->name('admin.add-admin');
    //edit Admin/Sub-Admins Route
    Route::match(['get','post'], '/edit-admin/{id}', 'AdminController@editAdmin');
    //Add CMS Pages
    Route::match(['get','post'], '/add-cms-page', 'CmsController@addCsmPage')->name('admin.add-cms-page');
    //View CSM Pages
    Route::get('/view-cms-pages','CmsController@viewCsmPages');

    //Details
    Route::match(['get','post'],'/detail-cms/{id}', 'CmsController@detailsCsmPages')->name('admin.detail-cmspage');
    //Edit CMS Page
    Route::match(['get','post'],'/edit-cms/{id}', 'CmsController@EditCsmPages')->name('admin.edit-cms');
    //Delete Csm Pages
    Route::get('/delete-cms-page/{id}', 'CmsController@deleteCmsPage');
    // Get Enquiries
    Route::get('/get-enquiries','CmsController@getEnquiries');
    // Get contact
    Route::get('/get-contact','CmsController@getContact');
    Route::get('/delete-contact/{id}', 'CmsController@deleteContact');

	// View Enquiries
	Route::get('/view-enquiries','CmsController@viewEnquiries');

    //currency route
    //add currency
    Route::match(['get','post'],'add-currency', 'CurrencyController@addCurrency')->name('admin.add-currency');
    //Edit currency
    Route::match(['get','post'],'edit-currency/{id}', 'CurrencyController@editCurrency')->name('admin.edit-currency');
    //view currency
    Route::get('view-currencies','CurrencyController@viewCurrency');

    //Delete Route

    Route::get('/delete-currency/{id}', 'CurrencyController@deleteCurrency');

    //view NewsletterSubscriber
    Route::get('/view-newsletter-subscribers','NewsletterController@viewSubscriber');
    //Update Newsletter StatusSubscriber
    Route::get('/update-newsletter-status/{id}/{Status}','NewsletterController@updateNewsletterStatus');
    //Delete Newsletter Email
    Route::get('/delete-newsletter-email/{id}', 'NewsletterController@deleteNewsletterEmail');


    //Export Newsletter Emails
    Route::get('/export-newsletter-email','NewsletterController@exportNewsletterEmails');
    //Export Users
    Route::get('/export-users','UsersController@exportUsers');
    Route::get('/export-services','ServicesController@exportServices');

    //view feedbacks
    Route::get('/view-feedbacks', 'FeedbackController@viewFeedback');
    //Update Feedback Status
    Route::get('/update-feedback/{id}/{Status}','FeedbackController@updateFeedbackStatus');
    //Delete Feedback
    Route::get('/delete-feedback/{id}', 'FeedbackController@deleteFeedback');
});




//Route::get('/register', 'UserController@createrUser');

Route::group(['middleware' => ['frontlogin']], function() {
    Route::match(['get','post'],'/account', 'UsersController@account');
    Route::get('/change_password', 'UsersController@change_password');
    Route::post('/check-user-pwd', 'UsersController@chkUserpassword');
    Route::post('/update-user-pwd', 'UsersController@updatepassword');
    //checkout page
    Route::match(['get','post'],'/billing', 'ServicesController@billing');
    //service Review Page
    Route::match(['get','post'],'/service-review','ServicesController@serviceReview');
    //Place Package
    Route::match(['get','post'],'/place-package','ServicesController@placePackage');
    //Thanks Page
    Route::get('/thanks', 'ServicesController@thanks');
    //ipay routes
    Route::get('/ipay','ServicesController@ipay');
    //flutter routes
    Route::get('/flutterwave','ServicesController@flutterwave');
    //ipay return thanks page
    Route::get('/ipay/thanks','ServicesController@ipaythanks');
    //ipay cancel page
    Route::get('/ipay/cancel','ServicesController@ipayCancel');
    //flutterwave return thanks page
    Route::get('/flutterwave/thanks','ServicesController@flutterwavethanks');
    //User Bookings Page
    Route::get('/Bookings', 'ServicesController@userBookings');
    //User Booked Package Page
    Route::get('/Bookings/{id}', 'ServicesController@userBookingDetails');
    //Feedback Route
    Route::match(['get','post'], '/feedback', 'FeedbackController@feedback');

});
//Auth::routes();

//display Contact Page
Route::match(['get','post'],'/contact', 'CmsController@contact');

// Display Post Page (for Vue.js)
Route::match(['get','post'],'/page/post','CmsController@addPost');

//Display Cms Pages
Route::match(['get','post'],'/{URL}','CmsController@cmsPage');




//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
