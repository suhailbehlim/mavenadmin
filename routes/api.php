<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('subscriber',[ApiController::class,'subs_list']);



Route::post("testfileupload", [ApiController::class,'testfileupload']);


Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    
    Route::post('register_user', 'ApiController@register_user')->name('register_user');
	Route::post('user_login', 'ApiController@user_login')->name('user_login'); 
	Route::post('forgot_password', 'ApiController@forgot_password');
	Route::post('verify_otp', 'ApiController@verify_otp');
	Route::post('change_password', 'ApiController@change_password');
	Route::post('profile', 'ApiController@profileUser');

	Route::get('cart_list/{user_id}', 'ApiController@cart_list');
	Route::post('add_to_cart', 'ApiController@add_to_cart');
	Route::post('update_cart', 'ApiController@update_cart');
	Route::get('remove_cart/{id}', 'ApiController@remove_cart');
	
	Route::post('add_to_wishlist', 'ApiController@add_to_wishlist');
	Route::post('remove_wishlist', 'ApiController@remove_wishlist');
	Route::get('wishlist/{user_id}', 'ApiController@wishlist');
	Route::get('event_list', 'ApiController@event_list');
	Route::get('event_detail/{id}', 'ApiController@event_detail');
	
	Route::get('skills_list', 'ApiController@skills_list');
	Route::get('courses_by_skill/{id}', 'ApiController@courses_by_skill');
	Route::get('vlsi_workshop', 'ApiController@vlsi_workshop');
	
    Route::post('dealerRegister', 'ApiController@dealerRegister')->name('dealerRegister');   
    //Route::post('testfileupload', 'ApiController@testfileupload')->name('testfileupload');  
    
    
    Route::get('countries', 'ApiController@countryList');
    Route::get('states', 'ApiController@stateList');  
    Route::get('banners', 'ApiController@bannerslist');
     Route::get('course_catalogelist', 'ApiController@course_catalogelist');
    Route::get('bodytypeList', 'ApiController@bodytypeList');
    Route::get('bodytypeListbymodal', 'ApiController@bodytypeListbymodal');
    Route::get('makeList', 'ApiController@makelist');
    Route::get('modalList', 'ApiController@modalList');
    Route::get('transmissionList', 'ApiController@transmissionList');
    Route::get('vehicleTypesList', 'ApiController@vehicleTypesList');
    Route::get('featuresList', 'ApiController@featuresList');
    Route::get('ourprogress', 'ApiController@ourprogress');
    Route::get('ProgrammeOffer', 'ApiController@ProgrammeOffer');
    Route::post('carPost', 'ApiController@carPost')->name('carPost'); 
    Route::post('carPost2', 'ApiController@carPost2')->name('carPost2');  
    Route::get('HomeRecentCarsList', 'ApiController@HomeRecentCarsList');  
    Route::get('HomePromotionalCarsList', 'ApiController@HomePromotionalCarsList');  
    Route::get('HomeFeaturedCarsList', 'ApiController@HomeFeaturedCarsList');  
    Route::get('UsedCarSearchResult', 'ApiController@UsedCarSearchResult');  
    Route::post('UsedCarSearchResult', 'ApiController@UsedCarSearchResult'); 
    Route::post('UsedCarSearchResultPaginate', 'ApiController@UsedCarSearchResultPaginate'); 
    
    Route::get('terms-of-services', 'ApiController@termsOfServices');
    
    Route::get('privacy-policy', 'ApiController@privacyPolicy');
    
    Route::get('AllPromotionalCarsList', 'ApiController@AllPromotionalCarsList'); 
    
    Route::get('AllFeaturedCarsList', 'ApiController@AllFeaturedCarsList');
    
    Route::get('AllRecentCarsList', 'ApiController@AllRecentCarsList'); 
    
    Route::get('AllRecentCarsListHome', 'ApiController@AllRecentCarsListHome');
    
    Route::post('socialRegistration', 'ApiController@socialRegistration')->name('socialRegistration');  
    
    Route::post('checksocialRegistration', 'ApiController@checksocialRegistration')->name('checksocialRegistration'); 
    
    Route::get('Dashboard', 'ApiController@Dashboard'); 
    Route::get('MyPost', 'ApiController@MyPost'); 
    Route::get('MySavedCars', 'ApiController@MySavedCars'); 
    Route::post('MakeCarSave', 'ApiController@MakeCarSave'); 
    Route::post('CarDetails', 'ApiController@CarDetails'); 
    Route::post('RequestInspection360', 'ApiController@RequestInspection360'); 
    Route::post('RequestBoost', 'ApiController@RequestBoost'); 
    Route::post('InspectionReport', 'ApiController@InspectionReport'); 
    Route::get('fuelTypeList', 'ApiController@fuelTypeList');
    Route::post('editcarPost', 'ApiController@editcarPost'); 
//    Route::post('makeOffer', 'ApiController@makeOffer'); 
    Route::get('carCalculator', 'ApiController@carCalculator'); 
    Route::post('carPostdelete', 'ApiController@carPostdelete'); 
    Route::get('makeOfferList', 'ApiController@makeOfferList'); 
    Route::get('notificationList', 'ApiController@notificationList'); 
    Route::post('update-profile', 'ApiController@updateProfile');
    
    Route::post('askadmin', 'ApiController@AskAdmin'); 
    
    Route::post('updateprofileimage', 'ApiController@UpdateProfileImage');
    Route::post('clienttodealer', 'ApiController@ClientToDealer');
    Route::post('checkdealership', 'ApiController@ClientCheckDealerRequest');
    Route::post('chatMessagesList', 'ApiController@ChatMessagesList'); 
    Route::post('sendchatmsg', 'ApiController@SendChatMsg'); 
    
    
    Route::post('makeOffernew', 'ApiController@makeOffernew_createchat');
    Route::post('chatMessagesListnew', 'ApiController@ChatMessagesListNew');
    Route::post('sendchatmsgnew', 'ApiController@SendChatMsgNew'); 
    Route::post('chatList', 'ApiController@ChatList');
    Route::post('SubscribeNewsletter', 'ApiController@SubscribeNewsletter');
    Route::post('ChangePassword', 'ApiController@ChangePassword');
    
    Route::post('CommentOnCar' ,  'ApiController@CommentOnCar');
    Route::get('fcmtest' ,  'ApiController@fcmtest');
    Route::post('ReportOnCar' ,  'ApiController@ReportOnCar');
    Route::post('ReportAsSold' ,  'ApiController@ReportAsSold');
    Route::get('logout', 'ApiController@logout');





    Route::get('courselist','ApiController@courselist');
Route::get('FaqList','ApiController@FaqList');
 
    
    
    
    
    
    
    
    
   
    Route::get('base-url', 'AuthController@index');    
//    Route::post('login', 'AuthController@login')->name('login');       
//    Route::post('userRegister', 'ApiController@userRegister')->name('userRegister');    
//    Route::post('customerRegister', 'AuthController@customerRegister')->name('customerRegister');    
//    Route::post('dealerRegister', 'AuthController@dealerRegister')->name('dealerRegister');    
//    Route::post('socialRegistration', 'AuthController@socialRegistration')->name('socialRegistration');    
    Route::get('notifications', 'AuthController@notificationList');    
//    Route::post('forgetPassword', 'AuthController@forgetPassword');
//    Route::get('banners', 'AuthController@bannerslist');
    
    
//    Route::get('logout', 'UserController@logout');

    Route::post('change-password', 'UserController@changePassword');

//    Route::post('update-profile', 'UserController@updateProfile');
//    Route::get('countries', 'AuthController@countryList');
//    Route::get('states', 'AuthController@stateList');    
    Route::get('cities', 'AuthController@cityList');    
    Route::get('companies', 'AuthController@companyList');    
    Route::get('categories', 'AuthController@categoryList');    
    Route::get('carModels', 'AuthController@carModelList');    
//    Route::get('privacy-policy', 'AuthController@privacyPolicy');    
//    Route::get('terms-of-services', 'AuthController@termsOfServices');
    
    


//blog categories
Route::get('bloglist', 'ApiController@bloglist');
Route::get('blogcategories', 'ApiController@blogcategories');
Route::get('blog_by_category/{id}', 'ApiController@blog_by_category');
Route::post('blogsearch', 'ApiController@blogsearch');
Route::get('blogdetail/{id}', 'ApiController@blogdetail');

//career api

Route::get('careerlist', 'ApiController@careerlist');
Route::post('careersearch', 'ApiController@careersearch');
//testomonial api
Route::get('testomoniallist', 'ApiController@testomoniallist');
Route::get('vlsiresourcelist', 'ApiController@vlsiresourcelist');
Route::post('searchvlsiresource', 'ApiController@searchvlsiresource');
Route::get('vlsiresourcecatlilst', 'ApiController@vlsiresourcecatlilst');
Route::get('vlsiresourcecatfilter/{cat}', 'ApiController@vlsiresourcecatfilter');
//partner api
Route::get('partnerlist', 'ApiController@partnerlist');
Route::get('placementlist', 'ApiController@placementlist');
Route::get('featuresList', 'ApiController@featuresList');
Route::get('courses_categories', 'ApiController@courses_categories');
Route::get('courses_by_category/{id}', 'ApiController@courses_by_category');
Route::post('search', 'ApiController@search');


Route::get('course_detail/{id}', 'ApiController@course_detail');


Route::get('course_description/{id}', 'ApiController@course_description');


Route::get('cms-section-List/{page}', 'ApiController@cms_section');
   //
   Route::post('addenquiry', 'ApiController@addenquiry');

    
     Route::group(['middleware' => ['web']], function () {

        Route::get('reset_password/{id}', 'AuthController@resetPassword');
        Route::post('updatePassword', 'AuthController@updatePassword')->name('api.updatePassword');


    });  
    

	
	      




//    // API's for required authentication..
//    Route::group(['middleware' => 'jwt.auth'], function () {
//        Route::get('countries', 'AuthController@countryList');
//        Route::get('logout', 'UserController@logout');
//        
//        Route::post('change-password', 'UserController@changePassword');
//
//        Route::post('update-profile', 'UserController@updateProfile');
//        Route::get('states', 'AuthController@stateList');    
//        Route::get('cities', 'AuthController@cityList');    
//        Route::get('companies', 'AuthController@companyList');    
//        Route::get('categories', 'AuthController@categoryList');    
//        Route::get('carModels', 'AuthController@carModelList');    
//        Route::get('privacy-policy', 'AuthController@privacyPolicy');    
//        Route::get('terms-of-services', 'AuthController@termsOfServices');
//        Route::get('profile', 'AuthController@profile');
//        
//        Route::get('blogdetail/{id}', 'ApiController@blogdetail');

//    });

});