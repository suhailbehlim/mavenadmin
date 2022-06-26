<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function() {
   $exitCode = Artisan::call('cache:clear');
   // return what you want
});

Auth::routes();
// Google
Route::get('login/google',  [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
// Facebook
Route::get('login/facebook',  [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

Route::namespace('App\Http\Controllers')->group(function () {
	
	
	Route::post("ajax/upload/image", "AjaxController@uploadImageEditor")->name("upload.image");
    Route::get('login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::get('register/admin', 'Auth\RegisterController@showAdminRegisterForm')->name('register/admin');
    Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
    Route::view('/home', 'home')->middleware('auth');
 
    Route::get('admin/forgetPassword', 'Admin\AdminForgetPasswordController@index')->name('admin.forgetPassword');
    Route::post('admin/sendPasswordOnM ail', 'Admin\AdminForgetPasswordController@sendPasswordOnMail')->name('admin.sendPasswordOnMail');  
     Route::group(['middleware' => ['isAdmin']], function () {
     	   Route::get('/admin', 'Admin\DashboardController@index')->name('admin.');
    Route::get('admin/changePassword', 'Admin\DashboardController@changePassword')->name('admin.changePassword');
    Route::post('admin/updatePassword', 'Admin\DashboardController@updatePassword')->name('admin.updatePassword');
    Route::get('admin/updateProfile', 'Admin\DashboardController@updateProfile')->name('admin.updateProfile');
    Route::post('admin/saveProfile', 'Admin\DashboardController@saveProfile')->name('admin.saveProfile');
    
	Route::get('admin/student-list', 'Admin\CustomerController@index')->name('admin.customers');
	
    Route::get('admin/ajaxCustomerList', 'Admin\CustomerController@ajaxCustomerList')->name('admin.datatables.ajaxCustomerList');
    Route::get('admin/addStudent', 'Admin\CustomerController@addCustomer')->name('admin.addCustomer');
    Route::post('storeCustomer', 'Admin\CustomerController@storeCustomer')->name('admin.storeCustomer');
    Route::get('admin/editStudent/{id}', 'Admin\CustomerController@editCustomer')->name('admin.editCustomer');
    Route::post('updateCustomer/{id}', 'Admin\CustomerController@updateCustomer')->name('admin.updateCustomer');
    Route::get('admin/deleteCustomer/{id}', 'Admin\CustomerController@deleteCustomer')->name('admin.deleteCustomer');
    Route::get('admin/customerChangeStatus/{id}/{status}', 'Admin\CustomerController@customerChangeStatus')->name('admin.customerChangeStatus');
    Route::get('admin/showCustomerProfile', 'Admin\CustomerController@showCustomerProfile')->name('admin.showCustomerProfile');
    Route::get('admin/exportExcel/{type}', 'Admin\CustomerController@exportExcel')->name('admin.exportExcel');
	
    /* admin/dealer routes start */
    Route::get('admin/educator-list', 'Admin\DealerController@index')->name('admin.dealers');
    Route::get('admin/ajaxDealerList', 'Admin\DealerController@ajaxdealerList')->name('admin.datatables.ajaxDealerList');
    Route::get('admin/addEducator', 'Admin\DealerController@addDealer')->name('admin.addDealer');
    Route::post('storeDealer', 'Admin\DealerController@storeDealer')->name('admin.storeDealer');
    Route::get('admin/editEducator/{id}', 'Admin\DealerController@editDealer')->name('admin.editDealer');
    Route::post('updateDealer/{id}', 'Admin\DealerController@updateDealer')->name('admin.updateDealer');
    Route::get('admin/deleteDealer/{id}', 'Admin\DealerController@deleteDealer')->name('admin.deleteDealer');
    Route::get('admin/changeStatus/{id}/{status}', 'Admin\DealerController@changeStatus')->name('admin.changeStatus');
    Route::get('admin/showDealerProfile/{id}', 'Admin\DealerController@showDealerProfile')->name('admin.showDealerProfile');
    Route::get('admin/approveDealer/{id}', 'Admin\DealerController@approveDealer')->name('admin.approveDealer');
    Route::get('admin/dealerExportExcel/{type}', 'Admin\DealerController@dealerExportExcel')->name('admin.dealerExportExcel');
	
	///// Courses
	Route::get('admin/courses-list', 'Admin\CoursesController@index')->name('admin.courses');
	Route::get('admin/courses-description/{id}', 'Admin\CoursesController@course_description')->name('admin.description');
	Route::get('admin/courses-description-action/{type}/{id}/{actionId?}', 'Admin\CoursesController@course_description_action')->name('admin.courses-description-action');
	Route::get('admin/courses-description-delete/{type}/{id}', 'Admin\CoursesController@course_description_delete')->name('admin.courses-description-delete');
	Route::post('admin/courses-description-action-add/{type}/{id}', 'Admin\CoursesController@course_description_action_store')->name('admin.courses-description-action-add');
	Route::post('update-description', 'Admin\CoursesController@storedescription')->name('admin.storedescription');
    Route::get('admin/ajaxCoursesList', 'Admin\CoursesController@ajaxCoursesList')->name('admin.datatables.ajaxCoursesList');
    Route::get('admin/addCourse', 'Admin\CoursesController@addCourse')->name('admin.addCourse');
    Route::post('storeCourse', 'Admin\CoursesController@storeCourse')->name('admin.storeCourse');
    Route::get('admin/editCourse/{id}', 'Admin\CoursesController@editCourse')->name('admin.editCourse');
    Route::post('updateCourse/{id}', 'Admin\CoursesController@updateCourse')->name('admin.updateCourse');
    Route::get('admin/deleteCourse/{id}', 'Admin\CoursesController@deleteCourse')->name('admin.deleteCourse');
    Route::get('admin/changeStatusCourse/{id}/{status}', 'Admin\CoursesController@changeStatusCourse')->name('admin.changeStatusCourse');
    Route::get('admin/showCourse/{id}', 'Admin\CoursesController@showCourse')->name('admin.showCourse');
    Route::get('admin/CourseExportExcel/{type}', 'Admin\CoursesController@CourseExportExcel')->name('admin.CourseExportExcel');

    Route::get('admin/logout', 'Admin\DashboardController@logout')->name('admin.logout');
	Route::get('admin/getStates/{id}', 'Admin\CustomerController@getStates')->name('getStates');
	Route::get('admin/getCities/{id}', 'Admin\CustomerController@getCities')->name('getCities');
	Route::get('admin/countries', 'Admin\SettingController@index')->name('admin.countries');
	Route::get('admin/ajaxCountryList', 'Admin\SettingController@ajaxCountryList')->name('admin.datatables.ajaxCountryList');
	Route::get('admin/addCountry', 'Admin\SettingController@addCountry')->name('admin.addCountry');
	Route::post('storeCountry', 'Admin\SettingController@storeCountry')->name('admin.storeCountry');
	Route::get('admin/editCountry/{id}', 'Admin\SettingController@editCountry')->name('admin.editCountry');
	Route::post('updateCountry/{id}', 'Admin\SettingController@updateCountry')->name('admin.updateCountry');
	Route::get('admin/deleteCountry/{id}', 'Admin\SettingController@deleteCountry')->name('admin.deleteCountry');
    Route::get('admin/exportCountry/{type}', 'Admin\SettingController@exportCountry')->name('admin.exportCountry'); 
	// State Route start.. 
	Route::get('admin/states/{countryId}', 'Admin\SettingController@stateList')->name('admin.states');
	Route::get('admin/ajaxStateList/{countryId}', 'Admin\SettingController@ajaxStateList')->name('admin.datatables.ajaxStateList');
	Route::get('admin/addState/{countryId}', 'Admin\SettingController@addState')->name('admin.addState');
	Route::post('storeState/{countryId}', 'Admin\SettingController@storeState')->name('admin.storeState');
	Route::get('admin/editState/{id}/{countryId}', 'Admin\SettingController@editState')->name('admin.editState');
	Route::post('updateState/{stateId}/{countryId}', 'Admin\SettingController@updateState')->name('admin.updateState');
	Route::get('admin/deleteState/{id}', 'Admin\SettingController@deleteState')->name('admin.deleteState');
    Route::get('admin/exportState/{type}', 'Admin\SettingController@exportState')->name('admin.exportState');
	
	// City Route start.. 
	Route::get('admin/cities/{countryId}/{stateId}', 'Admin\SettingController@cityList')->name('admin.cities');
	Route::get('admin/ajaxCityList/{stateId}', 'Admin\SettingController@ajaxCityList')->name('admin.datatables.ajaxCityList');
	Route::get('admin/addCity/{countryId}/{stateId}', 'Admin\SettingController@addCity')->name('admin.addCity');
	Route::post('storeCity/{countryId}/{stateId}', 'Admin\SettingController@storeCity')->name('admin.storeCity');
	Route::get('admin/editCity/{countryId}/{stateId}/{cityId}', 'Admin\SettingController@editCity')->name('admin.editCity');
	Route::post('updateCity/{countryId}/{stateId}/{cityId}', 'Admin\SettingController@updateCity')->name('admin.updateCity');
	Route::get('admin/deleteCity/{id}', 'Admin\SettingController@deleteCity')->name('admin.deleteCity');
    Route::get('admin/exportCity/{type}/{stateId}', 'Admin\SettingController@exportCity')->name('admin.exportCity'); 


	// Company Route start.. 
	Route::get('admin/companies', 'Admin\SettingController@companyList')->name('admin.companies');
	Route::get('admin/ajaxCompanyList', 'Admin\SettingController@ajaxCompanyList')->name('admin.datatables.ajaxCompanyList');
	Route::get('admin/addCompany', 'Admin\SettingController@addCompany')->name('admin.addCompany');
	Route::post('storeCompany', 'Admin\SettingController@storeCompany')->name('admin.storeCompany');
	Route::get('admin/editCompany/{id}', 'Admin\SettingController@editCompany')->name('admin.editCompany');
	Route::post('updateCompany/{id}', 'Admin\SettingController@updateCompany')->name('admin.updateCompany');
	Route::get('admin/deleteCompany/{id}', 'Admin\SettingController@deleteCompany')->name('admin.deleteCompany');

    // car Model Route start.. 
    Route::get('admin/car_models', 'Admin\SettingController@modelList')->name('admin.car_models');
    Route::get('admin/ajaxModelList', 'Admin\SettingController@ajaxModelList')->name('admin.datatables.ajaxModelList');
    Route::get('admin/addModel', 'Admin\SettingController@addModel')->name('admin.addModel');
    Route::post('storeModel', 'Admin\SettingController@storeModel')->name('admin.storeModel');
    Route::get('admin/editModel/{id}', 'Admin\SettingController@editModel')->name('admin.editModel');
    Route::post('updateModel/{id}', 'Admin\SettingController@updateModel')->name('admin.updateModel');
    Route::get('admin/deleteModel/{id}', 'Admin\SettingController@deleteModel')->name('admin.deleteModel');
    Route::get('admin/updateCharges', 'Admin\SettingController@updateCharges')->name('admin.updateCharges');
    Route::post('admin/saveCharges', 'Admin\SettingController@saveCharges')->name('admin.saveCharges');
	
	// Notification Route start.. 
	Route::get('admin/notifications', 'Admin\SettingController@notificationList')->name('admin.notifications');
	Route::get('admin/ajaxNotificationList', 'Admin\SettingController@ajaxNotificationList')->name('admin.datatables.ajaxNotificationList');
	Route::get('admin/deleteNotification/{id}', 'Admin\SettingController@deleteNotification')->name('admin.deleteNotification');
	
	/////// By Pawan
	Route::get('admin/roles', 'Admin\RolesController@index')->name('admin.roles');
	Route::get('admin/add-role', 'Admin\RolesController@addRole')->name('admin.addRole');
	Route::post('storeRole', 'Admin\RolesController@storeRole')->name('admin.storeRole');
	Route::get('admin/ajaxRolesList', 'Admin\RolesController@ajaxRolesList')->name('admin.ajaxRolesList');
	Route::get('admin/deleteRole/{id}', 'Admin\RolesController@deleteRole')->name('admin.deleteRole');
	Route::get('admin/editRole/{id}', 'Admin\RolesController@editRole')->name('admin.editRole');
	Route::post('updateRole/{id}', 'Admin\RolesController@updateRole')->name('admin.updateRole');
	Route::get('admin/RoleChangeStatus/{id}/{status}', 'Admin\RolesController@RoleChangeStatus')->name('admin.RoleChangeStatus');
	
	//// used cars
	Route::get('admin/used_cars', 'Admin\CarsController@index')->name('admin.used_cars');
	Route::get('admin/ajaxUsedCarList', 'Admin\CarsController@ajaxUsedCarList')->name('admin.ajaxUsedCarList');
	Route::get('admin/deleteUsedCar/{id}', 'Admin\CarsController@deleteUsedCar')->name('admin.deleteUsedCar');
	Route::get('admin/editUsedCar/{id}', 'Admin\CarsController@editUsedCar')->name('admin.editUsedCar');
	Route::post('updateUsedCar/{id}', 'Admin\CarsController@updateUsedCar')->name('admin.updateUsedCar');
	Route::get('admin/UsedCarChangeStatus/{id}/{status}', 'Admin\CarsController@UsedCarChangeStatus')->name('admin.UsedCarChangeStatus');
	Route::get('admin/viewUsedCar/{id}', 'Admin\CarsController@viewUsedCar')->name('admin.viewUsedCar');
	Route::post('updateUsedCarImages/{id}', 'Admin\CarsController@updateUsedCarImages')->name('admin.updateUsedCarImages');
	Route::post('updateUsedCarMetas/{id}', 'Admin\CarsController@updateUsedCarMetas')->name('admin.updateUsedCarMetas');
	Route::post('updateUsedCarEnTrans/{id}', 'Admin\CarsController@updateUsedCarEnTrans')->name('admin.updateUsedCarEnTrans');
	Route::post('updateUsedCarFuelMile/{id}', 'Admin\CarsController@updateUsedCarFuelMile')->name('admin.updateUsedCarFuelMile');
	Route::post('updateUsedCarBolus/{id}', 'Admin\CarsController@updateUsedCarBolus')->name('admin.updateUsedCarBolus');
	Route::post('updateUsedStats/{id}', 'Admin\CarsController@updateUsedStats')->name('admin.updateUsedStats');
	Route::get('admin/addUsedCar', 'Admin\CarsController@addUsedCar')->name('admin.addUsedCar');
	Route::post('addCar/', 'Admin\CarsController@addCar')->name('admin.addCar');
	Route::get('admin/addUsedCarWithDealer/{id}', 'Admin\CarsController@addUsedCarWithDealer')->name('admin.addUsedCarWithDealer');
	Route::post('storeUsedCarStep1/{id}', 'Admin\CarsController@storeUsedCarStep1')->name('admin.storeUsedCarStep1'); 
	Route::post('storeUsedCarStep2/{id}', 'Admin\CarsController@storeUsedCarStep2')->name('admin.storeUsedCarStep2');
	Route::post('storeUsedCarStep3/{id}', 'Admin\CarsController@storeUsedCarStep3')->name('admin.storeUsedCarStep3');	
	Route::get('admin/addUsedCarWithDealerStep2/{id}', 'Admin\CarsController@addUsedCarWithDealerStep2')->name('admin.addUsedCarWithDealerStep2');
	Route::get('admin/addUsedCarWithDealerStep3/{id}', 'Admin\CarsController@addUsedCarWithDealerStep3')->name('admin.addUsedCarWithDealerStep3');
	Route::get('admin/viewReports/{id}', 'Admin\CarsController@viewReports')->name('admin.viewReports');
	Route::get('admin/ajaxReportList/{id}', 'Admin\CarsController@ajaxReportList')->name('admin.ajaxReportList');
	Route::get('admin/getModel/{id}', 'Admin\CarsController@getModel')->name('getModel');
	
	// Inspection
	Route::get('admin/inspection/{eid}', 'Admin\InspectionController@index')->name('admin.inspection');
	Route::get('admin/add-inspection/{eid}', 'Admin\InspectionController@addInspection')->name('admin.addInspection');
	Route::post('storeInspection', 'Admin\InspectionController@storeInspection')->name('admin.storeInspection');
	Route::get('admin/ajaxInspection/{eid}', 'Admin\InspectionController@ajaxInspection')->name('admin.ajaxInspection');
	Route::get('admin/deleteInspection/{id}', 'Admin\InspectionController@deleteInspection')->name('admin.deleteInspection');
	Route::get('admin/editInspection/{id}', 'Admin\InspectionController@editInspection')->name('admin.editInspection');
	Route::post('updateInspection/{id}', 'Admin\InspectionController@updateInspection')->name('admin.updateInspection');
	
	// banners
	Route::get('admin/banners', 'Admin\BannersController@index')->name('admin.banners');
	Route::get('admin/add-banner', 'Admin\BannersController@addBanner')->name('admin.banner');
	Route::post('storeBanner', 'Admin\BannersController@storeBanner')->name('admin.storeBanner');
	Route::get('admin/ajaxBannerList', 'Admin\BannersController@ajaxBannerList')->name('admin.ajaxBannerList');
	Route::get('admin/BannerChangeStatus/{id}/{status}', 'Admin\BannersController@BannerChangeStatus')->name('admin.BannerChangeStatus');
	Route::get('admin/deleteBanner/{id}', 'Admin\BannersController@deleteBanner')->name('admin.deleteBanner');
	Route::get('admin/editBanner/{id}', 'Admin\BannersController@editBanner')->name('admin.editBanner');
	Route::post('updateBanner/{id}', 'Admin\BannersController@updateBanner')->name('admin.updateBanner');

	// course_cataloge
	Route::get('admin/course_cataloge', 'Admin\CatalogeController@index')->name('admin.course_cataloge');
	Route::get('admin/add-cataloge', 'Admin\CatalogeController@addcataloge')->name('admin.addcataloge');
	Route::post('storecataloge', 'Admin\CatalogeController@storecataloge')->name('admin.storecataloge');


	Route::get('admin/deletecataloge/{id}', 'Admin\CatalogeController@deletecataloge')->name('admin.deletecataloge');
	Route::get('admin/editcataloge/{id}', 'Admin\CatalogeController@editcataloge')->name('admin.editcataloge');
	Route::post('updatecataloge/{id}', 'Admin\CatalogeController@updatecataloge')->name('admin.updatecataloge');
	
	// badges
	Route::get('admin/badges', 'Admin\BadgesController@index')->name('admin.badges');
	Route::get('admin/ajaxBadgesList', 'Admin\BadgesController@ajaxBadgesList')->name('admin.ajaxBadgesList');
	Route::get('admin/editBadge/{id}', 'Admin\BadgesController@editBadge')->name('admin.editBadge');
	Route::post('update360Request/{id}', 'Admin\BadgesController@update360Request')->name('admin.update360Request');
	Route::post('updateInspectionRequest/{id}', 'Admin\BadgesController@updateInspectionRequest')->name('admin.updateInspectionRequest');
	
	/// posts request
	Route::get('admin/posts_request', 'Admin\PostsController@index')->name('admin.posts_request');
	Route::get('admin/posts_pending', 'Admin\PostsController@posts_pending')->name('admin.posts_pending');
	Route::get('admin/ajaxRequestList', 'Admin\PostsController@ajaxRequestList')->name('admin.ajaxRequestList');
	Route::get('admin/ajaxPendingRequestList', 'Admin\PostsController@ajaxPendingRequestList')->name('admin.ajaxPendingRequestList');
	Route::get('admin/viewRequest/{id}', 'Admin\PostsController@viewRequest')->name('admin.viewRequest');
	Route::post('updateStatus/{id}', 'Admin\PostsController@updateStatus')->name('admin.updateStatus');

	/// Comments
	Route::get('admin/comments/{id}', 'Admin\CommentController@index')->name('admin.comments');
	Route::get('admin/ajaxCommentsList/{id}', 'Admin\CommentController@ajaxCommentsList')->name('admin.ajaxCommentsList');
	Route::get('admin/deleteComment/{id}', 'Admin\CommentController@deleteComment')->name('admin.deleteComment');
	Route::get('CommentChangeStatus/{id}/{status}', 'Admin\CommentController@CommentChangeStatus')->name('admin.CommentChangeStatus');

	// Tickets
	Route::get('admin/tickets', 'Admin\TicketsController@index')->name('admin.tickets');
	Route::get('admin/ajaxTicketsList', 'Admin\TicketsController@ajaxTicketsList')->name('admin.ajaxTicketsList');
	Route::get('admin/deleteTicket/{id}', 'Admin\TicketsController@deleteTicket')->name('admin.deleteTicket');
	Route::get('admin/viewTicket/{id}', 'Admin\TicketsController@viewTicket')->name('admin.viewTicket');
	Route::post('ticketReply', 'Admin\TicketsController@ticketReply')->name('admin.ticketReply');
	
	// body type
	Route::get('admin/body_list', 'Admin\BodyController@index')->name('admin.body_list');
	Route::get('admin/addBody', 'Admin\BodyController@addBody')->name('admin.addBody');
	Route::post('storeBody', 'Admin\BodyController@storeBody')->name('admin.storeBody');
	Route::get('admin/editBody/{id}', 'Admin\BodyController@editBody')->name('admin.editBody');
	Route::post('updateBody', 'Admin\BodyController@updateBody')->name('admin.updateBody');
	Route::get('admin/ajaxBodyTypeList', 'Admin\BodyController@ajaxBodyTypeList')->name('admin.ajaxBodyTypeList');
	Route::get('admin/deleteType/{id}', 'Admin\BodyController@deleteType')->name('admin.deleteType');
	
	// Fuel type
	Route::get('admin/fuel_types', 'Admin\FuelController@index')->name('admin.fuel_types');
	Route::get('admin/addFuel', 'Admin\FuelController@addFuel')->name('admin.addFuel');
	Route::post('storeFuelType', 'Admin\FuelController@storeFuelType')->name('admin.storeFuelType');
	Route::get('admin/editFuel/{id}', 'Admin\FuelController@editFuel')->name('admin.editFuel');
	Route::post('updateFuelType', 'Admin\FuelController@updateFuelType')->name('admin.updateFuelType');
	Route::get('admin/ajaxFuelTypeList', 'Admin\FuelController@ajaxFuelTypeList')->name('admin.ajaxFuelTypeList');
	Route::get('admin/deleteFuelType/{id}', 'Admin\FuelController@deleteFuelType')->name('admin.deleteFuelType');
	
	// Calculator
	Route::get('admin/calculator', 'Admin\SettingController@calculator')->name('admin.calculator');
    Route::post('admin/saveCalculator', 'Admin\SettingController@saveCalculator')->name('admin.saveCalculator');

	//BLOG
	Route::get('admin/blogindex', 'Admin\BlogController@blogindex')->name('admin.blogindex');
	Route::get('admin/blog', 'Admin\BlogController@blog')->name('admin.blog');
	Route::post('admin/addblog', 'Admin\BlogController@addblog')->name('admin.addblog');
	Route::get('admin/bloglist', 'Admin\BlogController@ajaxBloglist')->name('admin.ajaxBloglist');
	Route::get('admin/editblog/{id}', 'Admin\BlogController@editblog')->name('admin.editblog');
	Route::post('admin/updateblog/{id}', 'Admin\BlogController@updateblog')->name('admin.updateblog');
	Route::get('admin/deleteblog{id}', 'Admin\BlogController@deleteblog')->name('admin.deleteblog');
	Route::get('admin/changeStatusblog/{id}/{status}', 'Admin\BlogController@changeStatusblog')->name('admin.changeStatusblog');

//Blog category
	
Route::get('admin/blogcategories', 'Admin\BlogController@blogcategoryList')->name('admin.blogcategories');
Route::get('admin/ajaxblogCategoryList', 'Admin\BlogController@ajaxBlogCategoryList')->name('admin.ajaxBlogCategoryList');
Route::get('admin/addblogCategory', 'Admin\BlogController@addblogCategory')->name('admin.addblogCategory');
Route::post('storeblogCategory', 'Admin\BlogController@storeblogCategory')->name('admin.storeblogCategory');
Route::get('admin/editblogCategory/{id}', 'Admin\BlogController@editblogCategory')->name('admin.editblogCategory');
Route::post('updateblogCategory/{id}', 'Admin\BlogController@updateblogCategory')->name('admin.updateblogCategory');
Route::get('admin/deleteblogCategory/{id}', 'Admin\BlogController@deleteblogCategory')->name('admin.deleteblogCategory');

//FAQ

	Route::get('admin/faqindex', 'Admin\FaqController@index')->name('admin.faqindex');
	Route::get('admin/questions/addFaq', 'Admin\FaqController@addFaq')->name('admin.addFaq');
	Route::post('admin/questions/addquestion', 'Admin\FaqController@addquestion')->name('admin.addquestion');
	Route::get('admin/faqlist', 'Admin\FaqController@ajaxFaqlist')->name('admin.ajaxFaqlist');
	Route::get('admin/editfaq/{id}', 'Admin\FaqController@editfaq')->name('admin.editfaq');
    Route::get('admin/deletefaq{id}', 'Admin\FaqController@deletefaq')->name('admin.deletefaq');
	Route::get('admin/changeStatusfaq/{id}/{status}', 'Admin\FaqController@changeStatusfaq')->name('admin.changeStatusfaq');
	Route::post('admin/updatefaq/{id}', 'Admin\FaqController@updatefaq')->name('admin.updatefaq');


//category


	Route::post('storeCategory', 'Admin\CategoryController@storeCategory')->name('admin.storeCategory');
	Route::get('admin/editCategory/{id}', 'Admin\CategoryController@editCategory')->name('admin.editCategory');
	Route::post('updateCategory/{id}', 'Admin\CategoryController@updateCategory')->name('admin.updateCategory');
	Route::get('admin/deleteCategory/{id}', 'Admin\CategoryController@deleteCategory')->name('admin.deleteCategory');
	Route::get('admin/addCategory', 'Admin\CategoryController@addCategory')->name('admin.addCategory');
	Route::get('admin/ajaxCategoryList', 'Admin\CategoryController@ajaxCategoryList')->name('admin.ajaxCategoryList');
	Route::get('admin/categories', 'Admin\CategoryController@categoryList')->name('admin.categoryList');

	
	//career

	Route::get('addCareer', 'Admin\CareerController@addCareer')->name('admin.addCareer');
Route::post('storeCareer','Admin\CareerController@storeCareer')->name('admin.storeCareer');
	Route::get('admin/careerlist', 'Admin\CareerController@careerlist')->name('admin.careerlist');
	Route::get('admin/ajaxCareerList', 'Admin\CareerController@ajaxCareerList')->name('admin.ajaxCareerList');
	Route::post('updateCareer/{id}', 'Admin\CareerController@updateCareer')->name('admin.updateCareer');
	Route::get('admin/editCareer/{id}', 'Admin\CareerController@editCareer')->name('admin.editCareer');
	Route::get('admin/deleteCareer/{id}', 'Admin\CareerController@deleteCareer')->name('admin.deleteCareer');
	Route::get('admin/changeStatusCareer/{id}/{status}', 'Admin\CareerController@changeStatusCareer')->name('admin.changeStatusCareer');
	
	
	//Enuiry
		Route::get('admin/enquiryindex', 'Admin\EnquiryController@enquiryindex')->name('admin.enquiryindex');
		Route::get('admin/ajaxenquiryList', 'Admin\EnquiryController@ajaxenquiryList')->name('admin.ajaxenquiryList');
		
	//Subscribers	
		Route::get('admin/subsindex', 'Admin\SubsController@subsindex')->name('admin.subsindex');
		Route::get('admin/ajaxsubsList', 'Admin\SubsController@ajaxsubsList')->name('admin.ajaxsubsList');
		Route::get('admin/addsubscribers' , 'Admin\SubsController@addsubscribers')->name('admin.addsubscribers');
		Route::match(['get','post'],'admin/sendsubsdata' ,'Admin\SubsController@sendsubsdata' )->name('admin.sendsubsdata');
	

	//testomonials
	Route::get('addTestomonial', 'Admin\CareerController@addTestomonial')->name('admin.addTestomonial');
	Route::post('storeTestomonial','Admin\CareerController@storeTestomonial')->name('admin.storeTestomonial');
		Route::get('admin/testomonialList', 'Admin\CareerController@testomonialList')->name('admin.testomonialList');
		Route::get('admin/ajaxtestomonialList', 'Admin\CareerController@ajaxtestomonialList')->name('admin.ajaxtestomonialList');
		Route::post('updateTestomonial/{id}', 'Admin\CareerController@updateTestomonial')->name('admin.updateTestomonial');
		Route::get('admin/editTestomonial/{id}', 'Admin\CareerController@editTestomonial')->name('admin.editTestomonial');
		Route::get('admin/deleteTestomonial/{id}', 'Admin\CareerController@deleteTestomonial')->name('admin.deleteTestomonial');
		Route::get('admin/changeStatusTestomonial/{id}/{status}', 'Admin\CareerController@changeStatusTestomonial')->name('admin.changeStatusTestomonial');

		//cms-section
	Route::get('add-cms-section', 'Admin\CmsSectionController@add_cms_section')->name('admin.add-cms-section');
	Route::post('store-cms-section','Admin\CmsSectionController@store_cms_section')->name('admin.store-cms-section');
		Route::get('admin/cms-section-List', 'Admin\CmsSectionController@cms_section_list')->name('admin.cms-section');
		
		Route::post('update-cms-section/{id}', 'Admin\CmsSectionController@update_cms_section')->name('admin.update-cms-section');
		Route::get('admin/edit-cms-section/{id}', 'Admin\CmsSectionController@edit_cms_section')->name('admin.edit-cms-section');
		Route::get('admin/delete-cms-section/{id}', 'Admin\CmsSectionController@delete_cms_section')->name('admin.delete-cms-section');

		//partner-section
	Route::get('add-partner', 'Admin\PartnersSectionController@add_partner')->name('admin.add-partner');
	Route::post('store-partner','Admin\PartnersSectionController@store_partner')->name('admin.store-partner');
		Route::get('admin/partner-List', 'Admin\PartnersSectionController@partner_list')->name('admin.partner');
		
		Route::post('update-partner/{id}', 'Admin\PartnersSectionController@update_partner')->name('admin.update-partner');
		Route::get('admin/edit-partner/{id}', 'Admin\PartnersSectionController@edit_partner')->name('admin.edit-partner');
		Route::get('admin/delete-partner/{id}', 'Admin\PartnersSectionController@delete_partner')->name('admin.delete-partner');

			//PLACEMENT UPDATES
	Route::get('add-placement-update', 'Admin\placementUpdateController@add_placement_update')->name('admin.add-placement-update');
	Route::post('store-placement-update','Admin\placementUpdateController@store_placement_update')->name('admin.store-placement-update');
		
		Route::get('admin/placement', 'Admin\placementUpdateController@placement_update_list')->name('admin.placement');
		
		Route::post('update-placement-update/{id}', 'Admin\placementUpdateController@update_placement_update')->name('admin.update-placement-update');
		Route::get('admin/edit-placement-update/{id}', 'Admin\placementUpdateController@edit_placement_update')->name('admin.edit-placement-update');
		Route::get('admin/delete-placement-update/{id}', 'Admin\placementUpdateController@delete_placement_update')->name('admin.delete-placement-update');

		//orders
	Route::get('admin/list/{type}', 'Admin\featuresController@orderList')->name('admin.order');

	//features
	Route::get('add-features', 'Admin\featuresController@add_features')->name('admin.add-features');
	
	Route::post('store-features','Admin\featuresController@store_features')->name('admin.store-features');
		Route::get('admin/features', 'Admin\featuresController@features_list')->name('admin.features');
		
		Route::post('update-features/{id}', 'Admin\featuresController@update_features')->name('admin.update-features');
		Route::get('admin/edit-features/{id}', 'Admin\featuresController@edit_features')->name('admin.edit-features');
		Route::get('admin/delete-features/{id}', 'Admin\featuresController@delete_features')->name('admin.delete-features');
Route::get('admin/ourprogress', 'Admin\featuresController@ourprogress')->name('admin.ourprogress');
Route::post('update-ourprogress', 'Admin\featuresController@updateourprogress')->name('admin.update-progress');
		//ProgrammeOffer
	Route::get('add-programme', 'Admin\programmeController@add_programme')->name('admin.add-programme');
	Route::post('store-programme','Admin\programmeController@store_programme')->name('admin.store-programme');
		Route::get('admin/programme', 'Admin\programmeController@programme_list')->name('admin.programme');
		
		Route::post('update-programme/{id}', 'Admin\programmeController@update_programme')->name('admin.update-programme');
		Route::get('admin/edit-programme/{id}', 'Admin\programmeController@edit_programme')->name('admin.edit-programme');
		Route::get('admin/delete-programme/{id}', 'Admin\programmeController@delete_programme')->name('admin.delete-programme');
		
//vlsi list

       Route::get('admin/ajaxvlsiList', 'Admin\CareerController@ajaxvlsiList')->name('admin.ajaxvlsiList');

		Route::get('admin/vlsiList', 'Admin\CareerController@vlsiList')->name('admin.vlsiList');
		Route::get('addvlsi', 'Admin\CareerController@addvlsi')->name('admin.addvlsi');
		Route::post('storevlsi','Admin\CareerController@storevlsi')->name('admin.storevlsi');
			Route::get('admin/testomonialList', 'Admin\CareerController@testomonialList')->name('admin.testomonialList');
			Route::post('updatevlsi/{id}', 'Admin\CareerController@updatevlsi')->name('admin.updatevlsi');
			Route::get('admin/editvlsi/{id}', 'Admin\CareerController@editvlsi')->name('admin.editvlsi');
			Route::get('admin/deletevlsi/{id}', 'Admin\CareerController@deletevlsi')->name('admin.deletevlsi');
			Route::get('admin/changeStatusvlsi/{id}/{status}', 'Admin\CareerController@changeStatusvlsi')->name('admin.changeStatusvlsi');
			Route::get('admin/exportvideo/{type}', 'Admin\CareerController@exportvideo')->name('admin.exportvideo');
		Route::get('admin/exportpdf/{type}', 'Admin\CareerController@exportpdf')->name('admin.exportpdf');


//WORKSHOP list//
Route::get('admin/workshopindex', 'Admin\WorkshopController@workshopindex')->name('admin.workshopindex');
Route::get('admin/workshopage', 'Admin\WorkshopController@workshopage')->name('admin.workshopage');
Route::get('admin/ajaxworkshopList', 'Admin\WorkshopController@ajaxworkshopList')->name('admin.ajaxworkshopList');
Route::post('workshopUpdate', 'Admin\WorkshopController@workshopUpdate')->name('admin.workshopUpdate');
Route::get('admin/addLifeBanner', 'Admin\WorkshopController@addLifeBanner')->name('admin.addLifeBanner');	
Route::post('storeLifeBanners', 'Admin\WorkshopController@storeLifeBanners')->name('admin.storeLifeBanners');
Route::get('admin/deleteBanner/{id}', 'Admin\WorkshopController@deleteBanner')->name('admin.deleteBanner');

Route::post('updateLifeBanners', 'Admin\WorkshopController@updateLifeBanners')->name('admin.updateLifeBanners');




// About//
// Route::get('addCareer', 'Admin\CareerController@addCareer')->name('admin.addCareer');
// Route::post('storeCareer','Admin\CareerController@storeCareer')->name('admin.storeCareer');
// 	Route::get('admin/careerlist', 'Admin\CareerController@careerlist')->name('admin.careerlist');
// 	Route::get('admin/ajaxCareerList', 'Admin\CareerController@ajaxCareerList')->name('admin.ajaxCareerList');
// 	Route::post('updateCareer/{id}', 'Admin\CareerController@updateCareer')->name('admin.updateCareer');
// 	Route::get('admin/editCareer/{id}', 'Admin\CareerController@editCareer')->name('admin.editCareer');
// 	Route::get('admin/deleteCareer/{id}', 'Admin\CareerController@deleteCareer')->name('admin.deleteCareer');
// 	Route::get('admin/changeStatusCareer/{id}/{status}', 'Admin\CareerController@changeStatusCareer')->name('admin.changeStatusCareer');
		});
});