<?php
Route::post('/agent/signup', 'Agent\AgentController@signup')->name('agent.signup'); 
Route::prefix('agent')->group(function() {
  //Login and Logout 
Route::get('/', 'Auth\AgentLoginController@showLoginForm')->name('agent.login');
Route::get('/login', 'Auth\AgentLoginController@showLoginForm')->name('agent.login');
Route::post('/login', 'Auth\AgentLoginController@login')->name('agent.login');
Route::post('/logout', 'Auth\AgentLoginController@logout')->name('agent.logout');

Route::get('/dashboard', 'Agent\DashboardController@dashboard')->name('agent.dashboard');
Route::get('/balance_refresh', 'Agent\DashboardController@balance_refresh')->name('agent.balance_refresh');
Route::get('/credit_refresh', 'Agent\DashboardController@credit_refresh')->name('agent.credit_refresh');

Route::get('/profile', 'Agent\DashboardController@myProfile')->name('agent.profile');  
Route::get('/edit-profile', 'Agent\DashboardController@editProfile')->name('agent.edit_profile');
Route::post('/edit-profile', 'Agent\DashboardController@editProfile')->name('agent.edit_profile');

Route::get('/change_password', 'Agent\DashboardController@change_password')->name('agent.change_password');
Route::post('/change_password', 'Agent\DashboardController@change_password')->name('agent.change_password');
/*Wallet Module*/
Route::get('/wallet', 'Agent\WalletController@Walletform')->name('agent.wallet');
Route::get('/recharge/history', 'Agent\WalletController@RechargeHistory')->name('agent.rechargehistory');
Route::post('/wallet/store', 'Agent\WalletController@Walletstore')->name('agent.walletstore');
Route::get('/wallet/crdrhistory', 'Agent\WalletController@Crdrhistory')->name('agent.crdrhistory');

/*Flight Module*/
Route::get('/search-again', 'Agent\FlightController@searchagain')->name('searchagain');
Route::get('/flight/index', 'Agent\FlightController@Flightindex')->name('agent.flights');
Route::get('/FlightList/index', 'Agent\FlightController@flightList');
Route::get('/FlightList/ajax', 'Agent\FlightController@flightListajax')->name('flightListajax');
Route::get('/Review/Checkout', 'Agent\FlightController@booking')->name('booking.checkout');
Route::get('/Flight/ticket', 'Agent\FlightController@ticket')->name('booking.ticket');
Route::get('/Flight/farerules', 'Agent\FlightController@farerules')->name('booking.farerules');
Route::post('/Flight/response', 'Agent\PaymentController@response')->name('booking.response');
Route::get('/Flight/returnticket', 'Agent\FlightController@Returnticket')->name('booking.returnticket');
Route::get('/Flight/ApplyCoupon', 'Agent\FlightController@ApplyCoupon')->name('booking.applycoupon');
Route::get('/Flight/FareQuote', 'Agent\FlightController@FareQuote')->name('booking.farequote');
Route::get('/Passenger/GetSSR', 'Agent\FlightController@GetSSR')->name('booking.getssr');
Route::get('/Passenger/travelplan', 'Agent\FlightController@TravelPlans')->name('booking.travelplan');
Route::get('/Calender/fare', 'Agent\FlightController@CalenderFare')->name('booking.calender');


Route::post('/Flight/payment', 'Agent\PaymentController@index')->name('booking.ticket');

Route::get('/Flight/cities', 'Agent\FlightController@cities')->name('booking.cities');
Route::get('/booking/error', 'Agent\FlightController@bookingerror')->name('booking.error');
Route::get('/booking/success/{id}', 'Agent\FlightController@BookingSuccess')->name('bookingsuccess');
Route::get('/ticket/{id}', 'Agent\FlightController@BookingTicket')->name('bookingticket');
Route::get('/emailticket/{id}', 'Agent\FlightController@EmailBookingTicket')->name('emailbookingticket');
Route::get('/phoneticket/{id}', 'Agent\FlightController@PhoneBookingTicket')->name('phonebookingticket');
Route::get('/booking-failure', 'BookingfailureController@agentfaliure')->name('booking-failure.index');
Route::post('/agentrazor-payment', 'Agent\PaymentController@payWithRazorpay')->name('paywithrazorpay');


Route::get('/bookings', 'Agent\BookingController@index')->name('agent.bookings.index');		
Route::get('/log/{id}', 'Agent\BookingController@logs')->name('agent.bookings.log');
Route::get('/bookings/detail/{id}', 'Agent\BookingController@BookingDetail')->name('agent.bookings.detail');

Route::get('/transaction_log', 'Agent\TransactionController@index')->name('agent.transaction_log');
Route::get('/excel_transaction_log', 'Agent\TransactionController@excelReport')->name('agent.excel_transaction_log');
Route::get('/credit_limit_log', 'Agent\TransactionController@credit_limit_log')->name('agent.credit_limit_log');

// Profit Loss
Route::get('/profitloss', 'Agent\ProfitlossController@index')->name('agent.profitloss');

// Daily Sales Report 
Route::get('/report/dailysale', 'Agent\ReportController@dailysale')->name('agent.dailysale');
// Ledger Report 
Route::get('/report/ledger', 'Agent\ReportController@ledger')->name('agent.ledger');
}); 
?>