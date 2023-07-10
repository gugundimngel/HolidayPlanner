<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Webhook panel
Route::post('/success-webhook/{uniqueToken}', 'API\WebHookController@successWebhook')->name('success_webhook');


Route::get('destination-tour', 'API\DestinationController@destinationList');
Route::get('popular-tour', 'API\PackageController@PopularTour');
Route::get('destination-detail', 'API\DestinationController@destinationPackage');
Route::get('theme-detail', 'API\DestinationController@themePackage');
Route::get('search-destination-detail', 'API\DestinationController@searchdestinationPackage');
Route::get('package-detail', 'API\PackageController@Packagedetail');
Route::get('top-inclusion/{inclusionid}', 'API\DestinationController@topInclusion');
Route::get('inclusion/{inclusionid}', 'API\DestinationController@Inclusion');
Route::get('exclusion/{inclusionid}', 'API\DestinationController@Exclusion');
Route::get('query-contact', 'API\EnquiryController@QuickContact')->name('query.contact');
Route::get('filterdata', 'API\DestinationController@FilterData')->name('filterdata');
Route::get('location', 'API\DestinationController@Location')->name('location');
Route::get('/searchtour', 'API\DestinationController@Searchtour')->name('Searchtour'); 
Route::get('/holidaytype', 'API\PackageController@holidaytype')->name('holidaytype'); 
Route::get('/type-by-package/{typeid}', 'API\PackageController@holidaytypePackage')->name('holidaytypepackage'); 
Route::post('enquiry-contact', 'API\PackageController@enquiryContact')->name('enquiry.contact');
Route::get('page', 'API\PageController@Index')->name('page.slug');
 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



