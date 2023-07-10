<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'HomeController@index')->name('index');

Route::get('/monthly-sales', 'HomeController@monthlySales')->name('monthlySales');

Auth::routes(['register' => false]);

/*Route::get('/home', 'HomeController@index')->name('home');*/
Route::group(['namespace' => 'Admin'], function () {

	Route::get('/dashboard', 'AdminController@adminindex')->name('dashboard');
	
	//Change Password
	Route::get('/change-password', 'AdminController@changeAdminPassword')->name('admin.changePassoword');
	Route::post('/update-password', 'AdminController@updateAdminPassword')->name('admin.updatePassword');

});
//comman function
//sub territories
Route::post('get-sub-territories', 'HomeController@getSubTerritories')->name('admin.getSubTerritories');

//user
Route::post('add-associated-user', 'HomeController@saveUserContact')->name('saveUserContact');
Route::post('check-email-id', 'HomeController@checkEmailId')->name('checkEmailId');
Route::post('check-contact-number', 'HomeController@checkAssociatedUserNumber')->name('checkAssociatedUserNumber');

Route::post('get-associated-user', 'HomeController@getAssociatedUserSuggestion')->name('getAssociatedUserSuggestion');
Route::post('get-associated-user-row', 'HomeController@getAssociatedUserRow')->name('getAssociatedUserRow');

//all request auto suggestions
Route::post('get-doctor', 'HomeController@getDoctorSuggestion')->name('getDoctorSuggestion');
Route::post('get-mr', 'HomeController@getMrSuggestion')->name('getMrSuggestion');
Route::post('get-territory', 'HomeController@getTerritorySuggestion')->name('getTerritorySuggestion');

//dependent subterritory
Route::post('get-dependent-sub-territories', 'HomeController@getDependentSubTerritories')->name('getDependentSubTerritories');

//territory Route 
Route::get('/territory/territory-list', 'TerritoryController@territoryList')->name('admin.territoryList');
Route::get('/territory/add-territory', 'TerritoryController@addTerritory')->name('admin.addTerritory');
Route::post('/territory/save-territory', 'TerritoryController@saveTerritory')->name('admin.saveTerritory');
Route::get('/territory/edit-territory/{id}', 'TerritoryController@editTerritory')->name('admin.editTerritory');
Route::post('/territory/update-territory', 'TerritoryController@updateTerritory')->name('admin.updateTerritory');
Route::get('/territory/delete-territory/{id}', 'TerritoryController@deleteTerritory')->name('admin.deleteTerritory');
Route::post('/territory/change-territory-status', 'TerritoryController@changeTerritoryStatus')->name('admin.changeTerritoryStatus');

Route::post('/territory/linked-person-detail', 'TerritoryController@linkedPersonDetail')->name('admin.linkedPersonDetail');
Route::post('/territory/check-territory-priority', 'TerritoryController@checkTerritoryPriority')->name('admin.checkTerritoryPriority');


//subterritory brand
Route::get('/territory/sub-territory-list/{id}','TerritoryController@subTerritoryList')->name('admin.subTerritoryList');
Route::get('/territory/add-sub-territory/{id}','TerritoryController@addSubTerritory')->name('admin.addSubTerritory');
Route::post('/territory/save-sub-territory','TerritoryController@saveSubTerritory')->name('admin.saveSubTerritory');
Route::get('/territory/edit-sub-territory/{id}/{territory_id?}','TerritoryController@editSubTerritory')->name('admin.editSubTerritory');
Route::post('/territory/update-sub-territory','TerritoryController@updateSubTerritory')->name('admin.updateSubTerritory');		
Route::get('/territory/delete-sub-territory/{id}/{territory_id?}','TerritoryController@deleteSubTerritory')->name('admin.deleteSubTerritory');
Route::post('/territory/change-sub-territory-status','TerritoryController@changeSubTerritoryStatus')->name('admin.changeSubTerritoryStatus');
Route::post('/territory/check-sub-territory-priority', 'TerritoryController@checkSubTerritoryPriority')->name('admin.checkSubTerritoryPriority');


//Employee Route
Route::get('/employee/employee-list', 'EmployeeController@employeeList')->name('admin.employeeList');
Route::get('/employee/add-employee', 'EmployeeController@addEmployee')->name('admin.addEmployee');
Route::post('/employee/save-employee', 'EmployeeController@saveEmployee')->name('admin.saveEmployee');
Route::get('/employee/edit-employee/{id}', 'EmployeeController@editEmployee')->name('admin.editEmployee');
Route::post('/employee/save-edited-employee', 'EmployeeController@saveEditedEmployee')->name('admin.saveEditedEmployee');
Route::get('/employee/delete-employee/{id}', 'EmployeeController@deleteEmployee')->name('admin.deleteEmployee');
Route::post('/employee/check-email-exists', 'EmployeeController@checkEmailExists')->name('admin.checkEmailExists');
Route::post('/employee/employee-change-status', 'EmployeeController@employeeChangeStatus')->name('admin.employeeChangeStatus');

//Doctor Route
Route::get('/doctor/doctor-list', 'DoctorController@doctorList')->name('admin.doctorList');
Route::get('/doctor/add-doctor', 'DoctorController@addDoctor')->name('admin.addDoctor');
Route::post('/doctor/save-doctor', 'DoctorController@saveDoctor')->name('admin.saveDoctor');
Route::get('/doctor/edit-doctor/{id}', 'DoctorController@editDoctor')->name('admin.editDoctor');
Route::post('/doctor/save-edited-doctor', 'DoctorController@saveEditedDoctor')->name('admin.saveEditedDoctor');
Route::get('/doctor/delete-doctor/{id}', 'DoctorController@deleteDoctor')->name('admin.deleteDoctor');
Route::post('/doctor/check-doctor-email-exists', 'DoctorController@checkDoctorEmailExists')->name('admin.checkDoctorEmailExists');
Route::post('/doctor/check-doctor-mobile-exists', 'DoctorController@checkDoctorMobileExists')->name('admin.checkDoctorMobileExists');
Route::post('/doctor/doctor-change-status', 'DoctorController@doctorChangeStatus')->name('admin.doctorChangeStatus');

//manage profile
Route::get('/doctor/doctor-manage-profile/{id}', 'DoctorController@doctorManageProfile')->name('admin.doctorManageProfile');
Route::post('/doctor/doctor-commission', 'DoctorController@doctorCommission')->name('admin.doctorCommission');
Route::post('/doctor/edit-doctor-profile', 'DoctorController@editDoctorProfile')->name('admin.editDoctorProfile');
Route::post('/doctor/save-doctor-profile', 'DoctorController@saveDoctorProfile')->name('admin.saveDoctorProfile');
Route::post('/doctor/update-doctor-profile', 'DoctorController@updateDoctorProfile')->name('admin.updateDoctorProfile');
Route::get('/doctor/delete-doctor-profile/{doctor_id}/{id?}', 'DoctorController@deleteDoctorProfile')->name('admin.deleteDoctorProfile');

//commission calculation
Route::get('/doctor/doctor-commission-calculation/{doctor_id}/{id}', 'DoctorController@doctorCommision')->name('admin.doctorCommision');
Route::post('/doctor/save-doctor-commission', 'DoctorController@saveDoctorCommision')->name('admin.saveDoctorCommision');
Route::post('/doctor/update-doctor-commission', 'DoctorController@updateDoctorCommision')->name('admin.updateDoctorCommision');
Route::get('/doctor/delete-doctor-profile/{doctor_id}/{profile_id}/{id?}', 'DoctorController@deleteDoctorCommission')->name('admin.deleteDoctorCommission');

Route::post('/doctor/check-commission-date', 'DoctorController@checkCommissionDate')->name('admin.checkCommissionDate');
Route::post('/doctor/check-doctor-profile', 'DoctorController@checkDoctorProfile')->name('admin.checkDoctorProfile');

//doctor wise payment request
Route::match(['get', 'post'],'/doctor/doctor-request-list/{doctor_id?}/{id?}', 'DoctorController@doctorRequestList')->name('admin.doctorRequestList');
Route::post('/doctor/update-request-payment-genrated', 'DoctorController@updateRequestPaymentGenrated')->name('admin.updateRequestPaymentGenrated');
Route::post('/doctor/update-request-received-mr', 'DoctorController@updateRequestReceivedMr')->name('admin.updateRequestReceivedMr');
Route::post('/doctor/update-doctor-paid-doctor', 'DoctorController@updateDoctorPaidDoctor')->name('admin.updatePaidDoctor');

//profile wise sales
Route::match(['get', 'post'],'/doctor/doctor-sales-list/{doctor_id?}/{id?}', 'DoctorController@doctorSalesList')->name('admin.doctorSalesList');
Route::match(['get', 'post'],'/doctor/medical-store-wise-doctor-sales/{doctor_id?}/{id?}/{month?}/{year?}', 'DoctorController@doctorMedicalstoreWiseSales')->name('admin.doctorMedicalstoreWiseSales');

//add offset
Route::get('/doctor/add-offset/{doctor_id}/{id?}', 'DoctorController@doctorOffset')->name('admin.doctorOffset');
Route::post('/doctor/save-offset', 'DoctorController@saveDoctorOffset')->name('admin.saveDoctorOffset');

//Mr Route
Route::get('/mr/mr-list', 'MrController@mrList')->name('admin.mrList');
Route::get('/mr/add-mr', 'MrController@addMr')->name('admin.addMr');
Route::post('/mr/save-mr', 'MrController@saveMr')->name('admin.saveMr');
Route::get('/mr/edit-mr/{id}', 'MrController@editMr')->name('admin.editMr');
Route::post('/mr/save-edited-mr', 'MrController@saveEditedMr')->name('admin.saveEditedMr');
Route::get('/mr/delete-mr/{id}', 'MrController@deleteMr')->name('admin.deleteMr');
Route::post('/mr/check-mr-email-exists', 'MrController@checkMrEmailExists')->name('admin.checkMrEmailExists');
Route::post('/mr/mr-change-status', 'MrController@mrChangeStatus')->name('admin.mrChangeStatus');

//Medical Store Route
Route::get('/medical-store/store-list', 'MedicalStoreController@storeList')->name('admin.storeList');
Route::get('/medical-store/add-store', 'MedicalStoreController@addStore')->name('admin.addStore');
Route::post('/medical-store/save-store', 'MedicalStoreController@saveStore')->name('admin.saveStore');
Route::get('/medical-store/edit-store/{id}', 'MedicalStoreController@editStore')->name('admin.editStore');
Route::post('/medical-store/save-edited-store', 'MedicalStoreController@saveEditedStore')->name('admin.saveEditedStore');
Route::get('/medical-store/delete-store/{id}', 'MedicalStoreController@deleteStore')->name('admin.deleteStore');
Route::post('/medical-store/store-gst-number', 'MedicalStoreController@storeGstNumber')->name('admin.storeGstNumber');
Route::post('/medical-store/store-users', 'MedicalStoreController@storeUsers')->name('admin.storeUsers');
Route::post('/medical-store/remove-store-users', 'MedicalStoreController@removeStoreUsers')->name('admin.removeStoreUsers');

//Stockiest Route
Route::get('/stockiest/stockiest-list', 'StockiestController@stockiestList')->name('admin.stockiestList');
Route::get('/stockiest/add-stockiest', 'StockiestController@addStockiest')->name('admin.addStockiest');
Route::post('/stockiest/save-stockiest', 'StockiestController@saveStockiest')->name('admin.saveStockiest');
Route::get('/stockiest/edit-stockiest/{id}', 'StockiestController@editStockiest')->name('admin.editStockiest');
Route::post('/stockiest/save-edited-stockiest', 'StockiestController@saveEditedStockiest')->name('admin.saveEditedStockiest');
Route::get('/stockiest/delete-stockiest/{id}', 'StockiestController@deleteStockiest')->name('admin.deleteStockiest');
Route::post('/stockiest/stockiest-gst-number', 'StockiestController@stockiestGstNumber')->name('admin.stockiestGstNumber');
Route::post('/stockiest/stockiest-users', 'StockiestController@stockiestUsers')->name('admin.stockiestUsers');
Route::post('/stockiest/remove-stockiest-users', 'StockiestController@removeStockiestUsers')->name('admin.removeStockiestUsers');

//associated users list
Route::match(['get', 'post'],'/associated-user/associated-user-list', 'MedicalStoreController@associatedUserList')->name('admin.associatedUserList');
Route::post('/associated-user/edit-associated-user', 'MedicalStoreController@editAssociatedUser')->name('admin.editAssociatedUser');
Route::post('/associated-user/update-associated-user', 'MedicalStoreController@saveEditedAssociatedUser')->name('admin.saveEditedAssociatedUser');
Route::get('/associated-user/delete-associated-user/{id}', 'MedicalStoreController@deleteAssociatedUser')->name('admin.deleteAssociatedUser');
Route::post('/associated-user/associated-user-agency', 'MedicalStoreController@associatedUserAgencies')->name('admin.associatedUserAgencies');
Route::post('/associated-user/remove-associated-user', 'MedicalStoreController@removeAssociatedUser')->name('admin.removeAssociatedUser');

//sales history 
Route::match(['get', 'post'],'/sales-history/sales-history-list', 'SalesHistoryController@salesHistoryList')->name('admin.salesHistoryList');
Route::post('/sales-history/confirm-status', 'SalesHistoryController@salesStatusChange')->name('admin.salesStatusChange');

//mr wise stockiest
Route::get('/sales-history/mr-history-report/{id?}', 'SalesHistoryController@mrHistoryReportList')->name('admin.mrHistoryReportList');
Route::post('/sales-history/save-stockist-amount', 'SalesHistoryController@saveStockiestAmount')->name('admin.saveStockiestAmount');
Route::post('/sales-history/stockist-statement', 'SalesHistoryController@stockiestStatement')->name('admin.stockiestStatement');
Route::post('/sales-history/stockist-attachment', 'SalesHistoryController@stockiestAttachment')->name('admin.stockiestAttachment');
Route::post('/sales-history/remove-statement', 'SalesHistoryController@removeAttachment')->name('admin.removeAttachment');
Route::get('/sales-history/delete-stockiest-data/{id}/{mr_id}', 'SalesHistoryController@deleteStockiestData')->name('admin.deleteStockiestData');
Route::get('/sales-history/download-statement-zip/{id}', 'SalesHistoryController@downloadStatementZip')->name('admin.downloadStatementZip');

//medical store history report
Route::get('/sales-history/medical-store-history-report/{id?}/{mr_id}', 'SalesHistoryController@medicalstoreHistoryReportList')->name('admin.medicalstoreHistoryReportList');
Route::post('/sales-history/save-medical-store-amount', 'SalesHistoryController@saveMedicalStoreAmount')->name('admin.saveMedicalStoreAmount');
Route::get('/sales-history/delete-stockiest-data/{id}/{stockiest_id?}/{mr_id?}', 'SalesHistoryController@deleteMedicalStoreData')->name('admin.deleteMedicalStoreData');

//Doctor sales report
Route::get('/sales-history/medical-doctor-sales-report/{id?}/{doctor_id?}/{stockiest_id?}/{mr_id?}', 'SalesHistoryController@medicalstoreDoctorSalesReport')->name('admin.medicalstoreDoctorSalesReport');
Route::post('/sales-history/save-doctor-amount', 'SalesHistoryController@saveDoctorAmount')->name('admin.saveDoctorAmount');
Route::get('/sales-history/delete-doctor-data/{id}/{store_id}/{stockiest_id?}/{mr_id?}', 'SalesHistoryController@deleteDoctorData')->name('admin.deleteDoctorData');

//doctor all request
Route::match(['get', 'post'],'/all-request/all-request-list', 'AllRequestController@allRequestList')->name('admin.allRequestList');

Route::post('/all-request/update-payment-genrated', 'AllRequestController@updatePaymentGenrated')->name('admin.updatePaymentGenrated');
Route::post('/all-request/update-received-mr', 'AllRequestController@updateReceivedMr')->name('admin.updateReceivedMr');
Route::post('/all-request/update-paid-doctor', 'AllRequestController@updatePaidDoctor')->name('admin.updatePaidDoctor');
Route::get('/all-request/view-doctor-request/{id}', 'AllRequestController@viewDoctorRequest')->name('admin.viewDoctorRequest');
Route::post('/all-request/update-status-payment', 'AllRequestController@updateStatusPayment')->name('admin.updateStatusPayment');

//Calendar Routes
Route::get('/calendar/event-list', 'CalendarController@eventList')->name('admin.eventList');

//Mr login panel route
Route::group(['prefix' => 'mr-panel', 'namespace' => 'Mr'], function () {

	//Change Password
	Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('mr.auth.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('mr.resetpassword');

});

Route::get('/truncate-table', 'HomeController@tuncateTable')->name('admin.tuncateTable');
