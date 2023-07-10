<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Api routes	
Route::post('store_logs','ApiController@LogInput')->name('store.logs');
Route::post('store_logoutput/{output}','ApiController@LogOutput')->name('store.logoutput');
Route::post('generate_device_token', 'ApiController@generateDeviceToken')->name('generateDeviceToken');


//mr login
Route::post('mr_login', 'ApiController@mrLogin')->name('mrLogin');

//forgot password
Route::post('mr_forgot_password', 'ApiController@mrForgotPassword')->name('mrForgotPassword');

//logout
Route::post('user_logout', 'ApiController@userLogout')->name('userLogout');

//change password
Route::post('change_password', 'ApiController@changePassword')->name('changePassword');

//stockist list
Route::post('stockist_list', 'ApiController@stockistList')->name('stockistList');

//update status of entry
Route::post('update_status', 'ApiController@updateStatus')->name('updateStatus');

//confirm status of stockist
// Route::post('stockist_confirm_status', 'ApiController@stockistConfirm')->name('stockistConfirm');

//upload document
Route::post('upload_document', 'ApiController@uploadDocument')->name('uploadDocument');

//medical store list
Route::post('medical_store_list', 'ApiController@medicalstoreList')->name('medicalstoreList');

//medical store list
Route::post('update_medical_store_amount', 'ApiController@updateAmountMedicalstore')->name('updateAmountMedicalstore');

//doctor list
Route::post('doctor_list', 'ApiController@doctorsList')->name('doctorsList');

//update doctor sales
Route::post('update_doctor_sales', 'ApiController@updateDoctorSales')->name('updateDoctorSales');

//update confirm data
Route::post('update_confirm_data', 'ApiController@updateConfirmData')->name('updateConfirmData');

//update confirm data
Route::post('uploaded_statement', 'ApiController@uploadStatement')->name('uploadStatement');

//remove statement
Route::post('remove_statement', 'ApiController@removeUploadStatement')->name('removeUploadStatement');

//mr doctor list
Route::post('mr_doctor_list', 'ApiController@mrDoctorList')->name('mrDoctorList');

//add request
Route::post('add_doctor_request', 'ApiController@addDoctorRequest')->name('addDoctorRequest');

//request list
Route::post('doctor_request_list', 'ApiController@doctorRequestList')->name('doctorRequestList');

//update doctor payment
Route::post('update_doctor_payment', 'ApiController@updateDoctorPayment')->name('updateDoctorPayment');

//all request list
Route::post('all_request_list', 'ApiController@allDoctorRequestList')->name('allDoctorRequestList');

//all events
Route::post('all_event', 'ApiController@calendarDetail')->name('calendarDetail');