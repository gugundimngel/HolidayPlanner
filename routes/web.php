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

/*********************General Function for Both (Front-end & Back-end) ***********************/
/* Route::post('/get_states', 'HomeController@getStates');
Route::post('/get_product_views', 'HomeController@getProductViews');
Route::post('/get_product_other_info', 'HomeController@getProductOtherInformation');
Route::post('/delete_action', 'HomeController@deleteAction')->middleware('auth');
 */
  Route::get('/clear-cache', function() {
	   
	 //$run = Artisan::call('schedule:run');
         $run = Artisan::call('config:clear');
        $run = Artisan::call('cache:clear');
        $run = Artisan::call('config:cache'); 
 /* $exitCode = \Artisan::call('HotelFetchs:hotelfetchs');
        $output = \Artisan::output();
        return $output; */
       return 'FINISHED';  
    });
Route::get('site/shutdown', function(){
    return Artisan::call('down');
});

Route::get('site/live', function(){
    return Artisan::call('up');
});
 
/*********************Exception Handling ***********************/
Route::get('/testco', 'TestController@index')->name('testco');
Route::get('/testpay', 'TestController@testpay')->name('testpay');
Route::post('/testuserpaywithrazorpay', 'TestController@testuserpaywithrazorpay')->name('testuserpaywithrazorpay');
Route::get('/exception', 'ExceptionController@index')->name('exception');
Route::post('/exception', 'ExceptionController@index')->name('exception');
Route::get('destinationtour', 'DestinationController@destinationList');

/*********************Front Panel Start ***********************/ 
//Coming Soon
Route::get('/coming_soon', 'HomeController@coming_soon')->name('coming_soon');	
Route::get('/agent/thanks', 'HomeController@Thanks')->name('thanks.agent');	
Route::get('/under_construction', 'HomeController@under_construction')->name('under_construction');	
Route::get('/holiday', 'HomeController@package')->name('holiday.index');	
Route::get('/hotels', 'HotelController@index')->name('hotel.index');	
Route::get('/ecash', 'HotelController@ecash')->name('hotel.ecash');	
Route::get('/visa', 'VisaController@index')->name('visa.index');
Route::post('/visa/search', 'VisaController@search')->name('visa.search');
Route::get('/visa/details/{id}', 'VisaController@details')->name('visa.details');
Route::post('/visa/save', 'VisaController@save')->name('visa.save');
Route::get('/offer', 'OfferController@index')->name('offer.index');	
Route::get('/flightstatus', 'FlightsController@FlightStatus')->name('FlightStatus.index');	
Route::get('/activities', 'ActivityController@index')->name('activities.index');	
Route::get('/trains', 'TrainController@index')->name('train.index');	
Route::get('/cruise', 'CruiseController@index')->name('cruise.index');	 
Route::get('/transfers', 'TransferController@index')->name('transfer.index');	
Route::get('/cab-booking', 'CabController@index')->name('cab.index');	
Route::get('/contact', 'ContactController@index')->name('contact.index');	 
Route::get('/view-ticket', 'FlightsController@viewTicket')->name('view.ticket');	 
Route::post('/contact/send', 'ContactController@Contact')->name('contact.send');	 
Route::get('/sendquery', 'SendqueryController@index')->name('sendquery.index');	 
Route::get('/career', 'CareerController@index')->name('career.index');	 
Route::get('/faq', 'FaqController@index')->name('faq.index');	  
Route::get('/hotelimport', 'HotelController@hotelimport');	  
 
Route::get('/view-print-booking', 'ViewprintbookingController@index')->name('view-print-booking.index');	 
Route::get('/booking-failure', 'BookingfailureController@index')->name('booking-failure.index');	 
Route::get('/agent-signup', 'AgentsignupController@index')->name('agent-signup.index');	 
Route::get('/payonline', 'PayonlineController@index')->name('payonline.index');	 

Route::get('/Search/filter', 'HotelsearchController@hotelsearchview')->name('hotel.hotelsearchview');	   
Route::get('/hotel-search', 'HotelsearchController@index')->name('hotel-search.index');	  
Route::get('/hotel-cities', 'HotelsearchController@hotelCities');	  
Route::get('/Hotel/HotelDetail', 'HotelsearchController@HotelDetail')->name('hotel-detail.HotelDetail');	  
Route::get('/hotel-booking', 'HotelbookingController@index')->name('hotel-booking.index');	   
Route::get('/Hotel/HotelListing', 'HotelsearchController@HotelListing')->name('hotel-booking.HotelListing');	   
Route::get('/Hotel/ajaxlisting', 'HotelsearchController@ajaxlisting')->name('hotel-booking.ajaxlisting');	   
Route::get('/Hotel/ajaxpricelisting', 'HotelsearchController@ajaxpricelisting')->name('hotel-booking.ajaxpricelisting');	   
	   
Route::get('/Hotel/Booking', 'HotelbookingController@index')->name('hotel-booking.HotelBooking');	   
Route::post('/Hotel/Payment', 'HotelbookingController@HotelPayment')->name('hotel-booking.HotelPayment');	   
Route::post('/Hotel/hotelpaywithrazorpay', 'HotelbookingController@HotelPay')->name('hotel-booking.HotelPay');	
Route::get('/Hotel/HotelBooking', 'HotelbookingController@HotelBooking')->name('hotel-booking.HotelsBooking');	   
Route::get('/Hotel/booking/success/{id}', 'HotelbookingController@HotelBookingSuccess')->name('hotel-booking.HotelsBookingSuccess');	   
Route::get('/Hotel/booking/hotelvoucher/{id}', 'HotelbookingController@hotelvoucher');
Route::post('/Hotel/booking/ticketmail', 'HotelbookingController@ticketmail');
	   
Route::get('/Hotel/cities', 'HotelController@HotelCities')->name('hotel-booking.HotelCities');	   

Route::get('/success', 'HomeController@success');	    
//Route::get('/success', 'HomeController@success');	 

Route::post('/razor-payment', 'PaymentController@payWithRazorpay')->name('userpaywithrazorpay');
Route::get('/do-not-close', 'PaymentController@donotClose')->name('donotcloe');

Route::post('/package-razor-payment', 'PackageController@payWithRazorpay')->name('userpackagepaywithrazorpay');
 
 
 Route::get('/flights', 'FlightsController@flightsG')->name('flightsG');
 
//Home Page 
Route::get('/', 'HomeController@index')->name('home');
Route::get('/package', 'HomeController@package')->name('package');
Route::get('/packageticket', 'PackageController@packageTicket')->name('packageticket');
Route::get('/package/ticket/{id}', 'PackageController@packageTicket')->name('packagetickets');
Route::get('/search-again', 'FlightsController@searchagain')->name('searchagain');
Route::get('/searchtour', 'HomeController@Searchtour')->name('Searchtour'); 
Route::get('/search', 'PackageController@Search')->name('search');  
Route::get('/package/booking/{packageid}', 'PackageController@packbooking')->name('packbooking'); 
Route::post('/package/payment', 'PackageController@payment')->name('packpayment'); 
Route::get('destinations/{slug}', 'PackageController@index')->name('destinations.package'); 
Route::get('page/{slug}', 'HomeController@Page')->name('page.slug'); 
Route::get('themes/{slug}', 'PackageController@theme')->name('theme.package'); 
Route::get('destinations/{dslug}/{slug}', 'PackageController@packdetails')->name('package.details'); 
Route::get('searchpackage', 'PackageController@searchpackagedetails')->name('searchpackage'); 
Route::get('sicaptcha', 'HomeController@sicaptcha')->name('sicaptcha'); 
Route::post('enquiry-contact', 'PackageController@enquiryContact')->name('query.contact'); 
Route::get('thanks', 'PackageController@thanks')->name('thanks');    
Route::get('invoice/secure/{slug}', 'InvoiceController@invoice')->name('invoice');   
Route::get('/invoice/download/{id}', 'InvoiceController@customer_invoice_download')->name('invoice.customer_invoice_download'); 
Route::get('/invoice/print/{id}', 'InvoiceController@customer_invoice_print')->name('invoice.customer_invoice_print');  
//singlepackage     
Route::get('/singlepackage', 'HomeController@singlepack')->name('singlepackage');
Route::get('/packdetails', 'HomeController@packdetails')->name('packdetails');
/*Flight Controller*/
Route::get('/FlightList/index', 'FlightsController@flightList')->name('flightList');
Route::get('/FlightListnew/index', 'FlightsController@flightListnew')->name('flightListnew');
Route::get('/FlightList/ajax', 'FlightsController@flightListajax')->name('flightListajax');
Route::get('/Review/Checkout', 'FlightsController@booking')->name('booking.checkout');
Route::get('/Flight/ticket', 'FlightsController@ticket')->name('booking.ticket');
Route::get('/Flight/farerules', 'FlightsController@farerules')->name('booking.farerules');
Route::post('/Flight/response', 'PaymentController@response')->name('booking.response');
Route::get('/Flight/returnticket', 'FlightsController@Returnticket')->name('booking.returnticket');
Route::get('/Flight/ApplyCoupon', 'FlightsController@ApplyCoupon')->name('booking.applycoupon');
Route::get('/Flight/FareQuote', 'FlightsController@FareQuote')->name('booking.farequote');
Route::get('/Passenger/GetSSR', 'FlightsController@GetSSR')->name('booking.getssr');
Route::get('/Passenger/travelplan', 'FlightsController@TravelPlans')->name('booking.travelplan');
Route::get('/Calender/fare', 'FlightsController@CalenderFare')->name('booking.calender');


Route::post('/Flight/payment', 'PaymentController@index')->name('booking.ticket');

Route::get('/Flight/cities', 'FlightsController@cities')->name('booking.cities');
Route::get('/booking/error', 'FlightsController@bookingerror')->name('booking.error');
Route::get('/booking/success/{id}', 'FlightsController@BookingSuccess')->name('bookingsuccess');
Route::get('/ticket/{id}', 'FlightsController@BookingTicket')->name('bookingticket');
Route::get('/emailticket/{id}', 'FlightsController@EmailBookingTicket')->name('emailbookingticket');
Route::get('/phoneticket/{id}', 'FlightsController@PhoneBookingTicket')->name('phonebookingticket');
/*Flight Controller*/
Route::get('/profile', 'HomeController@myprofile')->name('profile');   
//Login and Register
Auth::routes();
Route::get('auth/{provider}', 'Auth\SocialLoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback');

Route::post('/customer/login', 'Auth\LoginController@customerLogin')->name('customer.login');
Route::post('/forgot_password', 'HomeController@forgotPassword')->name('forgot_password');	
Route::get('/reset_link/{token}', 'HomeController@resetLink')->name('reset_link');	
Route::post('/reset_link', 'HomeController@resetLink')->name('reset_link');
//Forgot Password 
/* Route::get('/forgot_password', 'HomeController@forgotPassword')->name('forgot_password');	
Route::post('/forgot_password', 'HomeController@forgotPassword')->name('forgot_password');	

//Reset Link
Route::get('/reset_link/{token}', 'HomeController@resetLink')->name('reset_link');	
Route::post('/reset_link', 'HomeController@resetLink')->name('reset_link');	 */
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showPasswordResetForm')->name('reset_link');	
Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('user.password.update');

Route::get('/agents/password/reset/{token}', 'Auth\ResetPasswordController@showagentPasswordResetForm');	
Route::post('agents/password/reset', 'Auth\ResetPasswordController@resetagentPassword')->name('agent.password.update');
//All Professors
Route::get('/professors', 'ProfessorController@index')->name('professors.index');

//All Products linked to Individual Professor	
Route::get('/products/{id}', 'ProductController@index')->name('products.index');
Route::get('/view_product/{id}', 'ProductController@viewProduct')->name('products.view_product');
 
//Review Panel
Route::post('/add_review', 'DashboardController@addReview')->name('dashboard.add_review');

//Add Item into your Cart
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@index')->name('cart.index');
Route::post('/update_cart', 'CartController@updateCart')->name('cart.update_cart');
		
//Shipping Info 			
Route::get('/address', 'DashboardController@address')->name('dashboard.address');
Route::post('/address', 'DashboardController@address')->name('dashboard.address');

//Payment Process		
Route::get('/payment', 'PaymentController@index')->name('payment.index');
Route::post('/checkout', 'PaymentController@checkout')->name('payment.checkout');
Route::get('/payment_status', 'PaymentController@status')->name('payment.status');
	
//Thankyou Page
Route::get('/thankyou', 'PaymentController@thankyou')->name('payment.thankyou');

Route::post('/user/register','Auth\RegisterController@register')->name('user.register');

//Inner Dashboard 
Route::get('/user', 'DashboardController@index')->name('dashboard.index');
Route::get('/login-detail', 'DashboardController@loginDetail')->name('dashboard.logindetail');
Route::get('/tickets/printall', 'DashboardController@Printall')->name('booking.printall');
Route::get('dashboard/view_order_summary/{id}', 'DashboardController@viewOrderSummary')->name('dashboard.view_order_summary');
Route::get('/view_test_series_order/{id}', 'DashboardController@viewTestSeriesOrder')->name('dashboard.view_test_series_order');
Route::get('/test', 'TestController@index')->name('test.index');
Route::get('/view_test/{id}', 'TestController@viewTest')->name('test.view_test');
Route::post('/schedule_test_request', 'TestController@scheduleTestRequest')->name('test.schedule_test_request');
Route::post('/upload_answer', 'TestController@uploadAnswer')->name('test.upload_answer');
Route::post('/logout', 'DashboardController@logout')->name('logout');
Route::get('/verifyemail', 'DashboardController@verifyemail')->name('verifyemail');
Route::get('/verify/email/{token}', 'HomeController@updateverifyemail')->name('updateverifyemail');
Route::get('/verifymobile', 'DashboardController@verifymobile')->name('verifymobile');
Route::post('/uploadimage', 'DashboardController@uploadimage')->name('uploadimage');

//Other Functions
Route::get('/change_password', 'DashboardController@changePassword')->name('change_password');
Route::post('/change_password', 'DashboardController@changePassword')->name('change_password');			
Route::get('/my-profile', 'DashboardController@editProfile')->name('dashboard.edit_profile');
Route::post('/my-profile', 'DashboardController@editProfile')->name('dashboard.edit_profile');
Route::post('/edit-my-profile', 'DashboardController@editMyProfile')->name('dashboard.edit_myprofile');

Route::post('/package-enquiry','PackageController@package_enquiry')->name('package-enquiry');
/*---------------Agent Route-------------------*/
include_once 'agent.php';
/*---------------Agent Route-------------------*/
/*********************Admin Panel Start ***********************/
Route::prefix('admin')->group(function() {
    //Login and Logout 
		Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
		Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
		Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
		Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
	
	//General  
		Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');
		Route::get('/get_customer_detail', 'Admin\AdminController@CustomerDetail')->name('admin.get_customer_detail');
		Route::get('/my_profile', 'Admin\AdminController@myProfile')->name('admin.my_profile');
		Route::post('/my_profile', 'Admin\AdminController@myProfile')->name('admin.my_profile');
		Route::get('/change_password', 'Admin\AdminController@change_password')->name('admin.change_password');
		Route::post('/change_password', 'Admin\AdminController@change_password')->name('admin.change_password');
		Route::get('/multi_factor', 'Admin\AdminController@multi_factor')->name('admin.multi_factor');
		Route::post('/multi_factor', 'Admin\AdminController@multi_factor')->name('admin.multi_factor');
		Route::get('/sessions', 'Admin\AdminController@sessions')->name('admin.sessions');
		Route::post('/sessions', 'Admin\AdminController@sessions')->name('admin.sessions'); 
		Route::post('/delete_action', 'Admin\AdminController@deleteAction'); 
		Route::post('/delete_newaction', 'Admin\AdminController@deletenewAction'); 
		Route::post('/delete_package_action', 'Admin\AdminController@deletePackageAction');
		Route::post('/delete_all_action', 'Admin\AdminController@deleteAllAction');
		Route::post('/delete_dest_action', 'Admin\AdminController@deleteDesAction');
		Route::post('/delete_hotel_action', 'Admin\AdminController@deleteHotelAction');
		Route::post('/delete_inclusion_action', 'Admin\AdminController@deleteinclusionAction');
		Route::post('/delete_exclusions_action', 'Admin\AdminController@deleteexclusionsAction');
		Route::post('/delete_top_action', 'Admin\AdminController@deleteTopAction');
		Route::post('/delete_type_action', 'Admin\AdminController@deleteTypeAction');
		Route::post('/update_action', 'Admin\AdminController@updateAction');
		Route::post('/update_new_action', 'Admin\AdminController@updatenewAction');
		Route::post('/update_type_action', 'Admin\AdminController@updateTypeAction');
		Route::post('/add_ckeditior_image', 'Admin\AdminController@addCkeditiorImage')->name('add_ckeditior_image');
		Route::post('/get_chapters', 'Admin\AdminController@getChapters')->name('admin.get_chapters');
		Route::get('/website_setting', 'Admin\AdminController@websiteSetting')->name('admin.website_setting');
		Route::post('/website_setting', 'Admin\AdminController@websiteSetting')->name('admin.website_setting');
		Route::post('/get_states', 'Admin\AdminController@getStates');
		Route::get('/settings/taxes/returnsetting', 'Admin\AdminController@returnsetting')->name('admin.returnsetting');
		Route::get('/settings/taxes/taxrates', 'Admin\AdminController@taxrates')->name('admin.taxrates');
		Route::get('/settings/taxes/taxrates/create', 'Admin\AdminController@taxratescreate')->name('admin.taxrates.create');
		Route::post('/settings/taxes/taxrates/store', 'Admin\AdminController@savetaxrate')->name('admin.taxrates.store');
		Route::get('/settings/taxes/taxrates/edit/{id}', 'Admin\AdminController@edittaxrates')->name('admin.edittaxrates');
		Route::post('/settings/taxes/taxrates/edit', 'Admin\AdminController@edittaxrates')->name('admin.edittaxrates');
		Route::post('/settings/taxes/savereturnsetting', 'Admin\AdminController@returnsetting')->name('admin.savereturnsetting');
		
		Route::get('/settings/currencies', 'Admin\CurrencyController@index')->name('admin.currency.index');
		Route::get('/settings/currencies/edit/{id}', 'Admin\CurrencyController@edit')->name('admin.currency.edit');
		Route::post('/settings/currencies/edit', 'Admin\CurrencyController@edit')->name('admin.currency.edit');
		Route::get('/settings/currencies/create', 'Admin\CurrencyController@create')->name('admin.currency.create');
		Route::post('/settings/currencies/store', 'Admin\CurrencyController@store')->name('admin.currency.store');
		
	/*CRM route start*/
		Route::post('/uploadfile/store', 'Admin\MediaController@store')->name('admin.media.store');
		Route::get('/uploadfile/index', 'Admin\MediaController@index')->name('admin.media.index');
		Route::get('/uploadfile/delete', 'Admin\MediaController@deleteAction')->name('admin.media.delete');
		
		Route::get('/users', 'Admin\UserController@index')->name('admin.users.index');
		Route::get('/users/create', 'Admin\UserController@create')->name('admin.users.create'); 
		Route::post('/users/store', 'Admin\UserController@store')->name('admin.users.store');
		Route::get('/users/edit/{id}', 'Admin\UserController@edit')->name('admin.users.edit');
		Route::post('/users/edit', 'Admin\UserController@edit')->name('admin.users.edit');
		Route::get('/users/send-password/{id}', 'Admin\UserController@sendPassword')->name('admin.users.sendpassword');
		Route::get('/users/view/{id}', 'Admin\UserController@show')->name('admin.users.view');
		
		Route::get('/agents', 'Admin\AgentController@index')->name('admin.agents.index');
		Route::get('/agents/view/{id}', 'Admin\AgentController@show')->name('admin.agents.view');
		Route::get('/agents/setlimit/{id}', 'Admin\AgentController@setCreditlimit')->name('admin.agents.setlimit');
		Route::post('/agents/setlimit/', 'Admin\AgentController@setCreditlimit')->name('admin.agents.setlimit');
		Route::get('/agents/send-password/{id}', 'Admin\AgentController@sendPassword')->name('admin.agents.sendpassword');  
		
		Route::get('/agents/transactionlog/{id}', 'Admin\TransactionlogController@index')->name('admin.agents.transactionlog.index');   
		Route::get('/agents/credit_limit_log/{id}', 'Admin\TransactionlogController@credit_limit_log')->name('admin.agents.limitlog');     
		Route::get('/agents/agentlogin/{id}', 'Admin\AgentController@agentlogin')->name('admin.agents.agentlogin');
		Route::get('/excel_agents_log', 'Admin\AgentController@excelReport')->name('admin.excel_agents_log');     
		 
		Route::get('/staff', 'Admin\StaffController@index')->name('admin.staff.index');
		Route::get('/staff/create', 'Admin\StaffController@create')->name('admin.staff.create'); 
		Route::post('/staff/store', 'Admin\StaffController@store')->name('admin.staff.store');
		Route::get('/staff/edit/{id}', 'Admin\StaffController@edit')->name('admin.staff.edit');
		Route::post('/staff/edit', 'Admin\StaffController@edit')->name('admin.staff.edit');
		
		Route::get('/users/clientlist', 'Admin\UserController@clientlist')->name('admin.users.clientlist'); 		
		Route::get('/users/createclient', 'Admin\UserController@createclient')->name('admin.users.createclient'); 
		Route::post('/users/storeclient', 'Admin\UserController@storeclient')->name('admin.users.storeclient'); 
		Route::get('/users/editclient/{id}', 'Admin\UserController@editclient')->name('admin.users.editclient');
		Route::post('/users/editclient', 'Admin\UserController@editclient')->name('admin.users.editclient'); 
		Route::get('/excel_users_log', 'Admin\UserController@excelReport')->name('admin.excel_users_log'); 
		Route::post('/followup/store', 'Admin\FollowupController@store')->name('admin.followup.store'); 
		Route::get('/followup/list', 'Admin\FollowupController@index')->name('admin.followup.index'); 
		 
		Route::get('/usertype', 'Admin\UsertypeController@index')->name('admin.usertype.index');
		Route::get('/usertype/create', 'Admin\UsertypeController@create')->name('admin.usertype.create');  		
		Route::post('/usertype/store', 'Admin\UsertypeController@store')->name('admin.usertype.store');
		Route::get('/usertype/edit/{id}', 'Admin\UsertypeController@edit')->name('admin.usertype.edit');
		Route::post('/usertype/edit', 'Admin\UsertypeController@edit')->name('admin.usertype.edit');
		
		Route::get('/userrole', 'Admin\UserroleController@index')->name('admin.userrole.index');
		Route::get('/userrole/create', 'Admin\UserroleController@create')->name('admin.userrole.create');  
		Route::post('/userrole/store', 'Admin\UserroleController@store')->name('admin.userrole.store');
		Route::get('/userrole/edit/{id}', 'Admin\UserroleController@edit')->name('admin.userrole.edit');
		Route::post('/userrole/edit', 'Admin\UserroleController@edit')->name('admin.userrole.edit');
		
	//Manage Destination Start
		Route::get('/destination', 'Admin\ManagedestinationController@index')->name('admin.managedestination.index');
		Route::get('/destination/create', 'Admin\ManagedestinationController@create')->name('admin.managedestination.create'); 
		Route::post('/destination/store', 'Admin\ManagedestinationController@store')->name('admin.managedestination.store');
		Route::get('/destination/edit/{id}', 'Admin\ManagedestinationController@edit')->name('admin.managedestination.edit');
		Route::post('/destination/edit', 'Admin\ManagedestinationController@edit')->name('admin.managedestination.edit'); 
		 
		//Manage locations Start
		Route::get('/locations', 'Admin\LocationController@index')->name('admin.locations.index');
		Route::get('/locations/create', 'Admin\LocationController@create')->name('admin.locations.create'); 
		Route::post('/locations/store', 'Admin\LocationController@store')->name('admin.locations.store');
		Route::get('/locations/edit/{id}', 'Admin\LocationController@edit')->name('admin.locations.edit');
		Route::post('/locations/edit', 'Admin\LocationController@edit')->name('admin.locations.edit');  
		//Manage themes Start
		Route::get('/themes', 'Admin\ThemeController@index')->name('admin.themes.index');
		Route::get('/themes/create', 'Admin\ThemeController@create')->name('admin.themes.create'); 
		Route::post('/themes/store', 'Admin\ThemeController@store')->name('admin.themes.store');
		Route::get('/themes/edit/{id}', 'Admin\ThemeController@edit')->name('admin.themes.edit');
		Route::post('/themes/edit', 'Admin\ThemeController@edit')->name('admin.themes.edit');  
	 
	//Manage Hotel Start
		Route::get('/hotel', 'Admin\ManagehotelController@index')->name('admin.managehotel.index');
		Route::get('/hotel/create', 'Admin\ManagehotelController@create')->name('admin.managehotel.create');
		Route::post('/hotel/store', 'Admin\ManagehotelController@store')->name('admin.managehotel.store');
		Route::get('/hotel/edit/{id}', 'Admin\ManagehotelController@edit')->name('admin.managehotel.edit');
		Route::post('/hotel/edit', 'Admin\ManagehotelController@edit')->name('admin.managehotel.edit');	

	//Manage Inclusion Start
		Route::get('/inclusion', 'Admin\ManageinclusionController@index')->name('admin.manageinclusion.index');
		Route::get('/inclusion/create', 'Admin\ManageinclusionController@create')->name('admin.manageinclusion.create'); 
		Route::post('/inclusion/store', 'Admin\ManageinclusionController@store')->name('admin.manageinclusion.store');
		Route::get('/inclusion/edit/{id}', 'Admin\ManageinclusionController@edit')->name('admin.manageinclusion.edit');
		Route::post('/inclusion/edit', 'Admin\ManageinclusionController@edit')->name('admin.manageinclusion.edit');
		Route::post('/add_inclusion', 'Admin\AdminController@add_inclusion')->name('admin.add_inclusion');

	//Manage Exclusion Start
		Route::get('/exclusion', 'Admin\ManageexclusionController@index')->name('admin.manageexclusion.index');
		Route::get('/exclusion/create', 'Admin\ManageexclusionController@create')->name('admin.manageexclusion.create');
		Route::post('/exclusion/store', 'Admin\ManageexclusionController@store')->name('admin.manageexclusion.store');
		Route::get('/exclusion/edit/{id}', 'Admin\ManageexclusionController@edit')->name('admin.manageexclusion.edit');
		Route::post('/exclusion/edit', 'Admin\ManageexclusionController@edit')->name('admin.manageexclusion.edit');	
  
	//Manage Amenities Start 
		Route::get('/amenities', 'Admin\ManageamenitiesController@index')->name('admin.manageamenities.index');
		Route::get('/amenities/create', 'Admin\ManageamenitiesController@create')->name('admin.manageamenities.create');
		Route::post('/amenities/store', 'Admin\ManageamenitiesController@store')->name('admin.manageamenities.store');
		Route::get('/amenities/edit/{id}', 'Admin\ManageamenitiesController@edit')->name('admin.manageamenities.edit');
		Route::post('/amenities/edit', 'Admin\ManageamenitiesController@edit')->name('admin.manageamenities.edit');	
		 
	//Manage Holiday Type Start 
		Route::get('/holidaytype', 'Admin\ManageholidaytypeController@index')->name('admin.manageholidaytype.index');
		Route::get('/holidaytype/create', 'Admin\ManageholidaytypeController@create')->name('admin.manageholidaytype.create');
		Route::post('/holidaytype/store', 'Admin\ManageholidaytypeController@store')->name('admin.manageholidaytype.store');
		Route::get('/holidaytype/edit/{id}', 'Admin\ManageholidaytypeController@edit')->name('admin.manageholidaytype.edit');
		Route::post('/holidaytype/edit', 'Admin\ManageholidaytypeController@edit')->name('admin.manageholidaytype.edit');

	//Manage Top Inclusion Start
		Route::get('/topinclusion', 'Admin\ManagetopinclusionController@index')->name('admin.managetopinclusion.index');
		Route::get('/topinclusion/create', 'Admin\ManagetopinclusionController@create')->name('admin.managetopinclusion.create');
		Route::post('/topinclusion/store', 'Admin\ManagetopinclusionController@store')->name('admin.managetopinclusion.store');
		Route::get('/topinclusion/edit/{id}', 'Admin\ManagetopinclusionController@edit')->name('admin.managetopinclusion.edit');
		Route::post('/topinclusion/edit', 'Admin\ManagetopinclusionController@edit')->name('admin.managetopinclusion.edit');
		
		Route::get('/top-inclusion', 'Admin\TopinclusionController@index')->name('admin.topinclusion.index');
		Route::get('/top-inclusion/create', 'Admin\TopinclusionController@create')->name('admin.topinclusion.create');
		Route::post('/top-inclusion/store', 'Admin\TopinclusionController@store')->name('admin.topinclusion.store');
		Route::get('/top-inclusion/edit/{id}', 'Admin\TopinclusionController@edit')->name('admin.topinclusion.edit');
		Route::post('/top-inclusion/edit', 'Admin\TopinclusionController@edit')->name('admin.topinclusion.edit');
		
		
		//Manage Addon Start
		Route::get('/addons', 'Admin\ManageaddonController@index')->name('admin.manageaddon.index');
		Route::get('/addons/create', 'Admin\ManageaddonController@create')->name('admin.manageaddon.create');
		Route::post('/addons/store', 'Admin\ManageaddonController@store')->name('admin.manageaddon.store');
		Route::get('/addons/edit/{id}', 'Admin\ManageaddonController@edit')->name('admin.manageaddon.edit');
		Route::post('/addons/edit', 'Admin\ManageaddonController@edit')->name('admin.manageaddon.edit');
		
		//Manage Top Inclusion Start
		Route::get('/cities', 'Admin\ManagecityController@index')->name('admin.cities.index');
		Route::get('/fetch-cities', 'Admin\ManagecityController@fetchCities')->name('fetch.data.cities');
		Route::get('/cities/create', 'Admin\ManagecityController@create')->name('admin.cities.create');
		Route::post('/cities/store', 'Admin\ManagecityController@store')->name('admin.cities.store');
		Route::get('/cities/edit/{id}', 'Admin\ManagecityController@edit')->name('admin.cities.edit');
		Route::post('/cities/edit', 'Admin\ManagecityController@edit')->name('admin.cities.edit');
	
	//Manage Holiday Package Start
		Route::get('/holidaypackage', 'Admin\ManageholidaypackageController@index')->name('admin.manageholidaypackage.index');
		Route::get('/sort-package', 'Admin\ManageholidaypackageController@sortPackage')->name('admin.manageholidaypackage.sort');
		Route::post('/add-sort', 'Admin\ManageholidaypackageController@addSort')->name('admin.manageholidaypackage.addsort');
		Route::get('/holidaypackage/create', 'Admin\ManageholidaypackageController@create')->name('admin.manageholidaypackage.create');	
		Route::post('/holidaypackage/store', 'Admin\ManageholidaypackageController@store')->name('admin.manageholidaypackage.store');
		Route::get('/holidaypackage/edit/{id}', 'Admin\ManageholidaypackageController@edit')->name('admin.manageholidaypackage.edit');
		Route::post('/holidaypackage/edit', 'Admin\ManageholidaypackageController@edit')->name('admin.manageholidaypackage.edit'); 
		Route::get('/holidaypackage/duplicate/{id}', 'Admin\ManageholidaypackageController@duplicate')->name('admin.manageholidaypackage.duplicate');
		Route::post('/holidaypackage/store-duplicate', 'Admin\ManageholidaypackageController@storeDuplicate')->name('admin.manageholidaypackage.storeduplicate');
		
		Route::get('/getDestinations', 'Admin\ManageholidaypackageController@getDestinations')->name('getDestinations');	  
		Route::get('/getPackages', 'Admin\ManageholidaypackageController@getPackages')->name('getPackages');	  
		Route::get('/getHotels', 'Admin\ManageholidaypackageController@getHotels')->name('getHotels');	   
		 
	//Manage Gallery Start
		Route::get('/gallery', 'Admin\GalleryController@index')->name('admin.managegallery.index'); 
		Route::get('/gallery/create', 'Admin\GalleryController@create')->name('admin.managegallery.create');
		Route::post('/gallery/store', 'Admin\GalleryController@store')->name('admin.managegallery.store');
		Route::get('/gallery/edit/{id}', 'Admin\GalleryController@edit')->name('admin.managegallery.edit');
		Route::post('/gallery/edit', 'Admin\GalleryController@edit')->name('admin.managegallery.edit');		
	  
	     
	  //Manage Contacts Start   
		Route::get('/contact', 'Admin\ContactController@index')->name('admin.managecontact.index'); 
		Route::get('/contact/create', 'Admin\ContactController@create')->name('admin.managecontact.create');
		Route::post('/contact/store', 'Admin\ContactController@store')->name('admin.managecontact.store');
		Route::post('/contact/add', 'Admin\ContactController@add')->name('admin.managecontact.add');
		Route::get('/contact/edit/{id}', 'Admin\ContactController@edit')->name('admin.managecontact.edit');
		Route::post('/contact/edit', 'Admin\ContactController@edit')->name('admin.managecontact.edit');
		Route::post('/contact/storeaddress', 'Admin\ContactController@storeaddress')->name('admin.managecontact.edit');
		 
		//Leads Start    
		Route::get('/leads', 'Admin\LeadController@index')->name('admin.leads.index');  
		Route::get('/leads/history/{id}', 'Admin\LeadController@history')->name('admin.leads.history'); 
		Route::get('/leads/create', 'Admin\LeadController@create')->name('admin.leads.create');   
		Route::post('/leads/assign', 'Admin\LeadController@assign')->name('admin.leads.assign');    
		Route::get('/leads/edit/{id}', 'Admin\LeadController@edit')->name('admin.leads.edit');
		
		//Refer A Friend Start   
		Route::get('/referfriend', 'Admin\ReferfriendController@index')->name('admin.referfriend.index');  
		Route::get('/referfriend/create', 'Admin\ReferfriendController@create')->name('admin.referfriend.create');    
		Route::post('/leads/store', 'Admin\LeadController@store')->name('admin.leads.store');
		/*Route::get('/gallery/edit/{id}', 'Admin\GalleryController@edit')->name('admin.managegallery.edit');
		Route::post('/gallery/edit', 'Admin\GalleryController@edit')->name('admin.managegallery.edit');*/
		    
		//Invoices Start    
		Route::get('/invoice', 'Admin\InvoiceController@index')->name('admin.invoice.index');  
		Route::get('/invoice/lists/{id}', 'Admin\InvoiceController@lists')->name('admin.invoice.lists');  
		Route::get('/invoice/edit/{id}', 'Admin\InvoiceController@edit')->name('admin.invoice.edit');  
		Route::post('/invoice/edit', 'Admin\InvoiceController@edit')->name('admin.invoice.edit');  
		Route::get('/invoice/create', 'Admin\InvoiceController@create')->name('admin.invoice.create');   
		Route::post('/invoice/store', 'Admin\InvoiceController@store')->name('admin.invoice.store'); 
		Route::get('/invoice/detail', 'Admin\InvoiceController@detail')->name('admin.invoice.detail'); 
		Route::get('/invoice/email/{id}', 'Admin\InvoiceController@email')->name('admin.invoice.email'); 
		Route::post('/invoice/email', 'Admin\InvoiceController@email')->name('admin.invoice.email'); 
		Route::get('/invoice/editpayment', 'Admin\InvoiceController@editpayment')->name('admin.invoice.editpayment'); 
		Route::get('/invoice/invoicebyid', 'Admin\InvoiceController@invoicebyid')->name('admin.invoice.invoicebyid'); 
		Route::get('/invoice/history', 'Admin\InvoiceController@history')->name('admin.invoice.history'); 
		Route::post('/invoice/paymentsave', 'Admin\InvoiceController@paymentsave')->name('admin.invoice.paymentsave'); 
		Route::post('/invoice/editpaymentsave', 'Admin\InvoiceController@editpaymentsave')->name('admin.invoice.editpaymentsave'); 
		Route::post('/invoice/addcomment', 'Admin\InvoiceController@addcomment')->name('admin.invoice.addcomment'); 
		Route::post('/invoice/sharelink', 'Admin\InvoiceController@sharelink')->name('admin.invoice.sharelink'); 
		Route::post('/invoice/disablelink', 'Admin\InvoiceController@disablelink')->name('admin.invoice.disablelink'); 
		Route::get('/invoice/download/{id}', 'Admin\InvoiceController@customer_invoice_download')->name('admin.invoice.customer_invoice_download'); 
		Route::get('/invoice/print/{id}', 'Admin\InvoiceController@customer_invoice_print')->name('admin.invoice.customer_invoice_print'); 
		Route::get('/invoice/reminder/{id}', 'Admin\InvoiceController@reminder')->name('admin.invoice.reminder'); 
		Route::post('/invoice/reminder', 'Admin\InvoiceController@reminder')->name('admin.invoice.reminder'); 
		Route::post('/invoice/attachfile', 'Admin\InvoiceController@attachfile')->name('admin.invoice.attachfile'); 
		Route::get('/invoice/getattachfile', 'Admin\InvoiceController@getattachfile')->name('admin.invoice.getattachfile'); 
		Route::get('/invoice/removeattachfile', 'Admin\InvoiceController@removeattachfile')->name('admin.invoice.removeattachfile'); 
		Route::get('/invoice/attachfileemail', 'Admin\InvoiceController@attachfileemail')->name('admin.invoice.attachfileemail'); 
	  //Manage Api key 
	 // Route::get('/api-key', 'Admin\ApiController@index')->name('admin.apikey.index');
	  //Manage Api key  
				      
	//CMS Pages
		Route::get('/cms_pages', 'Admin\CmsPageController@index')->name('admin.cms_pages.index');
		Route::get('/cms_pages/create', 'Admin\CmsPageController@create')->name('admin.cms_pages.create');
		Route::post('/cms_pages/store', 'Admin\CmsPageController@store')->name('admin.cms_pages.store');
		Route::get('/cms_pages/edit/{id}', 'Admin\CmsPageController@editCmsPage')->name('admin.edit_cms_page');
		Route::post('/cms_pages/edit', 'Admin\CmsPageController@editCmsPage')->name('admin.edit_cms_page');
		
		//CMS Pages
		Route::get('/news', 'Admin\NewsController@index')->name('admin.news.index');
		Route::get('/news/create', 'Admin\NewsController@create')->name('admin.news.create');
		Route::post('/news/store', 'Admin\NewsController@store')->name('admin.news.store');
		Route::get('/news/edit/{id}', 'Admin\NewsController@editnewsPage')->name('admin.edit_news_page');
		Route::post('/news/edit', 'Admin\NewsController@editnewsPage')->name('admin.edit_news_page');
		
		//CMS Pages
		Route::get('/testimonial', 'Admin\TestimonialController@index')->name('admin.testimonial.index');
		Route::get('/testimonial/create', 'Admin\TestimonialController@create')->name('admin.testimonial.create');
		Route::post('/testimonial/store', 'Admin\TestimonialController@store')->name('admin.testimonial.store');
		Route::get('/testimonial/edit/{id}', 'Admin\TestimonialController@edittestimonialPage')->name('admin.edit_testimonial_page');
		Route::post('/testimonial/edit', 'Admin\TestimonialController@edittestimonialPage')->name('admin.edittestimonialPage');
	//Email Templates Pages
		Route::get('/email_templates', 'Admin\EmailTemplateController@index')->name('admin.email.index');
		Route::get('/email_templates/create', 'Admin\EmailTemplateController@create')->name('admin.email.create');
		Route::post('/email_templates/store', 'Admin\EmailTemplateController@store')->name('admin.email.store');
		Route::get('/edit_email_template/{id}', 'Admin\EmailTemplateController@editEmailTemplate')->name('admin.edit_email_template');
		Route::post('/edit_email_template', 'Admin\EmailTemplateController@editEmailTemplate')->name('admin.edit_email_template');	
		
	//SEO Tool
		Route::get('/edit_seo/{id}', 'Admin\AdminController@editSeo')->name('admin.edit_seo');
		Route::post('/edit_seo', 'Admin\AdminController@editSeo')->name('admin.edit_seo');
		
		Route::get('/api-key', 'Admin\AdminController@editapi')->name('admin.edit_api');
		Route::post('/api-key', 'Admin\AdminController@editapi')->name('admin.edit_api');	
		
		Route::get('/coupon-code', 'Admin\CouponController@index')->name('admin.coupon_code.index');
		Route::get('/coupon-code/create', 'Admin\CouponController@create')->name('admin.coupon_code.create');
		Route::post('/coupon-code/store', 'Admin\CouponController@store')->name('admin.coupon_code.store');
		Route::get('/coupon-code/edit/{id}', 'Admin\CouponController@edit')->name('admin.coupon_code.edit');
		Route::post('/coupon-code/edit', 'Admin\CouponController@edit')->name('admin.coupon_code.edit');

		Route::get('/bookings', 'Admin\BookingController@index')->name('admin.bookings.index');		
		Route::get('/log/{id}', 'Admin\BookingController@logs')->name('admin.bookings.log');
		Route::get('/hotellog/{id}', 'Admin\BookingController@hotellogs')->name('admin.bookings.hotellog');
		Route::get('/bookings/detail/{id}', 'Admin\BookingController@BookingDetail')->name('admin.bookings.detail');
		Route::get('/bookings/hoteldetail/{id}', 'Admin\BookingController@hotelBookingDetail')->name('admin.bookings.hoteldetail');
		
		Route::get('/settings/payment-gateway', 'Admin\PaymentGatewayController@index')->name('admin.paymentgateway');	
		Route::post('/settings/payment-gateway/store', 'Admin\PaymentGatewayController@store')->name('admin.paymentgateway.store');	
		
		Route::get('/settings/api', 'Admin\ApiController@index')->name('admin.api');	
		Route::post('/settings/api/store', 'Admin\ApiController@store')->name('admin.api.store');
		Route::post('/settings/api/hotelstore', 'Admin\ApiController@hotelstore')->name('admin.api.hotelstore');
		
		Route::get('/settings/sms-gateway', 'Admin\SmsGatewayController@index')->name('admin.smsgateway');	
		Route::post('/settings/sms-gateway/store', 'Admin\SmsGatewayController@store')->name('admin.smsgateway.store');
		 
		Route::get('/settings/bank-accounts', 'Admin\BankAccountController@index')->name('admin.manageaccounts.index');	
		Route::get('/settings/bank-accounts/create', 'Admin\BankAccountController@create')->name('admin.manageaccounts.create');	
		Route::get('/settings/bank-accounts/edit/{id}', 'Admin\BankAccountController@edit')->name('admin.manageaccounts.edit');	
		Route::post('/bank-accounts/store', 'Admin\BankAccountController@store')->name('admin.manageaccounts.store');	
		Route::post('/bank-accounts/edit', 'Admin\BankAccountController@edit')->name('admin.manageaccounts.edit');	
	// Flight Markup
		Route::get('/flightmarkup', 'Admin\FlightmarkupController@index')->name('admin.flightmarkup');	
		Route::get('/flightmarkup/create', 'Admin\FlightmarkupController@create')->name('admin.flightmarkup.create');	
		Route::post('/flightmarkup/store', 'Admin\FlightmarkupController@store')->name('admin.flightmarkup.store');	
		Route::post('/flightmarkup/update', 'Admin\FlightmarkupController@update')->name('admin.flightmarkup.update');	
		Route::get('/flightmarkup/commission', 'Admin\FlightmarkupController@commission')->name('admin.flightmarkup.commission');

// Hotel Markup
		Route::get('/hotelmarkup', 'Admin\HotelmarkupController@index')->name('admin.hotelmarkup');	
		Route::get('/hotelmarkup/create', 'Admin\HotelmarkupController@create')->name('admin.hotelmarkup.create');	
		Route::post('/hotelmarkup/store', 'Admin\HotelmarkupController@store')->name('admin.hotelmarkup.store');	
		Route::get('/hotelmarkup/edit/{id}', 'Admin\HotelmarkupController@edit')->name('admin.hotelmarkup.edit');	
		Route::post('/hotelmarkup/edit', 'Admin\HotelmarkupController@edit')->name('admin.hotelmarkup.edit');	
	
	//Visa Markup
	    Route::get('/visamarkup','Admin\VisamarkupController@index')->name('admin.visamarkup');
	
	// Profit Loss 
		Route::get('/profitloss', 'Admin\ProfitlossController@index')->name('admin.profitloss');
		
	// Service Fees 
		Route::get('/servicefees', 'Admin\ServicefeesController@index')->name('admin.servicefees');
		Route::post('/servicefees/store', 'Admin\ServicefeesController@store')->name('admin.servicefees.store');	
		
	// Daily Sales Report 
		Route::get('/report/dailysale', 'Admin\ReportController@dailysale')->name('admin.dailysale');
	// Ledger Report 
		Route::get('/report/ledger', 'Admin\ReportController@ledger')->name('admin.ledger');
// Wallet Page 
		Route::get('/wallet/index', 'Admin\WalletController@index')->name('admin.wallet.index'); 
		Route::get('/wallet/crdr', 'Admin\WalletController@crdr')->name('admin.wallet.crdr'); 
		Route::get('/wallet/create', 'Admin\WalletController@create')->name('admin.wallet.create'); 
		Route::post('/wallet/store', 'Admin\WalletController@store')->name('admin.wallet.store'); 
		Route::get('/wallet/edit/{id}', 'Admin\WalletController@edit')->name('admin.wallet.edit'); 
		Route::post('/wallet/edit', 'Admin\WalletController@edit')->name('admin.wallet.edit'); 	
		Route::get('/wallet/view/{id}', 'Admin\WalletController@show')->name('admin.wallet.view'); 
		Route::get('/wallet/excel_waller_log', 'Admin\WalletController@excelReport')->name('admin.excel_waller_log'); 
		//Flight Pages
		Route::get('/flights', 'Admin\FlightsController@index')->name('admin.flights.index'); 
		Route::get('/flights/edit/{id}', 'Admin\FlightsController@edit')->name('admin.flights.edit');	
		Route::post('/flights/edit', 'Admin\FlightsController@edit')->name('admin.flights.edit');	
		Route::get('/flights/create', 'Admin\FlightsController@create')->name('admin.flights.create');	
		Route::post('/flights/store', 'Admin\FlightsController@store')->name('admin.flights.store');

	//Flight Details Pages
		Route::get('/flight-detail', 'Admin\FlightsController@FlightDetailindex')->name('admin.flightdetail.index'); 
		Route::get('/flight-detail/edit/{id}', 'Admin\FlightsController@FlightDetailindexEdit')->name('admin.flightdetail.edit');	
		Route::post('/flight-detail/edit', 'Admin\FlightsController@FlightDetailindexEdit')->name('admin.flightdetail.edit');	
		Route::get('/flight-detail/create', 'Admin\FlightsController@FlightDetailindexCreate')->name('admin.flightdetail.create');	
		Route::post('/flight-detail/store', 'Admin\FlightsController@FlightDetailindexStore')->name('admin.flightdetail.store');
		
		Route::get('/flight-detail/clone/{id}', 'Admin\FlightsController@FlightDetailindexClone')->name('admin.flightdetail.clone');
		Route::post('/flight-detail/clone', 'Admin\FlightsController@FlightDetailindexClone')->name('admin.flightdetail.clone');
		Route::get('/getFlights', 'Admin\FlightsController@getFlights')->name('getFlights');
		Route::get('/searchFlights', 'Admin\FlightsController@searchFlights')->name('searchFlights');
		
		Route::get('/photo-gallery/getlist', 'Admin\MediaController@getlist')->name('admin.photo.getlist');
		Route::post('/photo-gallery/uploadlist', 'Admin\MediaController@uploadlist')->name('admin.photo.uploadlist');
		Route::post('/photo-gallery/update_action', 'Admin\MediaController@update_action')->name('admin.photo.update_action');
	
	 
	//GRN Hotel 
		Route::get('/grnhotel', 'Admin\GRNHotelController@index')->name('admin.grnhotel.index'); 
		Route::get('/grnhotel/edit/{id}', 'Admin\GRNHotelController@edit')->name('admin.grnhotel.edit');	
		Route::post('/grnhotel/edit', 'Admin\GRNHotelController@edit')->name('admin.grnhotel.edit');	
		Route::get('/searchlist', 'Admin\GRNHotelController@searchlist')->name('admin.grnhotel.searchlist');
		Route::get('/rooms', 'Admin\GRNHotelController@rooms')->name('admin.rooms.index');
		Route::get('/rooms/edit', 'Admin\GRNHotelController@roomsedit')->name('admin.rooms.edit');
		Route::post('/rooms/edit', 'Admin\GRNHotelController@roomsedit')->name('admin.rooms.edit');

		
		Route::get('/grnhotelfacilties', 'Admin\GRNHotelController@grnhotelfacilties')->name('admin.grnhotelfacilties.index');	
		Route::get('/grnhotelfacilties/edit/{id}', 'Admin\GRNHotelController@editgrnhotelfacilties')->name('admin.grnhotelfacilties.edit');	
		Route::post('/grnhotelfacilties/edit', 'Admin\GRNHotelController@editgrnhotelfacilties')->name('admin.grnhotelfacilties.edit');	
		Route::get('/gethotel', 'Admin\GRNHotelController@gethotel');	
		Route::get('/getcity', 'Admin\GRNHotelController@getcity');	
		
		
		Route::get('/bookings/hotelvoucher/{id}', 'Admin\BookingController@hotelvoucher')->name('admin.hotelvoucher.index');	
	//Agent Offer
		Route::get('/agent-offers', 'Admin\AgentOfferController@index')->name('admin.agentoffers.index'); 
		Route::get('/agent-offers/edit/{id}', 'Admin\AgentOfferController@edit')->name('admin.agentoffers.edit');	
		Route::post('/agent-offers/edit', 'Admin\AgentOfferController@edit')->name('admin.agentoffers.edit');	
		Route::get('/agent-offers/create', 'Admin\AgentOfferController@create')->name('admin.agentoffers.create');	
		Route::post('/agent-offers/store', 'Admin\AgentOfferController@store')->name('admin.agentoffers.store');
		
		
		Route::get('/visa/view', 'Admin\VisaController@index')->name('admin.visa.index'); 
		Route::get('/visa/add', 'Admin\VisaController@add')->name('admin.visa.add'); 
		Route::get('/visa/edit/{id}', 'Admin\VisaController@add')->name('admin.visa.edit'); 
		Route::post('/visa/save', 'Admin\VisaController@save')->name('admin.visa.save'); 
		Route::get('/visa/booking/list', 'Admin\VisaController@visa_query')->name('admin.visa.visa_query'); 
		Route::post('/visa/popular_status','Admin\VisaController@popular_status')->name('admin.visa.popular_status');
		Route::post('/visa/delete','Admin\VisaController@delete_visa')->name('admin.visa.delete');
		
		Route::get('/visa/category','Admin\VisaController@category')->name('admin.visa.category');
		Route::post('/visa/category/add','Admin\VisaController@addCategory')->name('admin.visa.category.add');
		Route::post('/visa/category/delete','Admin\VisaController@deleteCategory')->name('admin.visa.category.delete');
		
		Route::get('visa/price','Admin\VisaController@price')->name('admin.visa.price');
});      