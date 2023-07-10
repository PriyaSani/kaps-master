<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('plugins/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('plugins/node-waves/waves.min.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('plugins/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ asset('js/pages/dashboard.init.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

<!-- jQuery Validation-->
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<!-- Login js-->
<script src="{{ asset('js/common_validation.js') }}"></script>

<script src="{{ asset('plugins/dropify/dist/js/dropify.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/pages/developer.js') }}"></script>

<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/pages/datatables.init.js') }}"></script>   

<script src="{{ asset('plugins/cropper/croppie.js') }}"></script>

<script src="{{ asset('plugins/cropper/scripts.js') }}"></script>

<script src="{{ asset('js/validation.js') }}"></script>

<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
	
<script src="{{asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<script src="{{asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>

<script src="{{asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

<script src="{{ asset('js/pages/form-advanced.init.js') }}"></script>

<script src="{{ asset('js/common.js') }}"></script>

<script src="{{ asset('js/company_user.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="{{asset('plugins/apexcharts/apexcharts.min.js')}}"></script>

<script src="{{asset('js/pages/dashboard.init.js')}}"></script>

@if (\Route::current()->getName() == 'admin.territoryList') 
<script src="{{asset('js/page_js/territory_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.subTerritoryList') 
<script src="{{asset('js/page_js/sub_territory_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.employeeList') 
<script src="{{asset('js/page_js/employee_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.addEmployee') 
<script src="{{asset('js/page_js/add_employee.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.editEmployee') 
<script src="{{asset('js/page_js/edit_employee.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.addMr') 
<script src="{{asset('js/page_js/add_mr.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.editMr') 
<script src="{{asset('js/page_js/edit_mr.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.mrList') 
<script src="{{asset('js/page_js/mr_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.doctorList') 
<script src="{{asset('js/page_js/doctor_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.addDoctor') 
<script src="{{asset('js/page_js/add_doctor.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.editDoctor') 
<script src="{{asset('js/page_js/edit_doctor.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.doctorManageProfile')
<script src="{{asset('js/page_js/doctor_profile_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.doctorCommision')
<script src="{{asset('js/page_js/commission_calculation.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.doctorRequestList')
<script src="{{asset('js/page_js/doctor_payment_request_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.doctorSalesList')
<script src="{{asset('js/page_js/doctor_sales_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.storeList')
<script src="{{asset('js/page_js/medical_store_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.addStore')
<script src="{{asset('js/page_js/add_medical_store.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.editStore')
<script src="{{asset('js/page_js/edit_medical_store.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.stockiestList')
<script src="{{asset('js/page_js/stockiest_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.addStockiest')
<script src="{{asset('js/page_js/add_stockiest.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.editStockiest')
<script src="{{asset('js/page_js/edit_stockiest.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.associatedUserList')
<script src="{{asset('js/page_js/associate_user_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.salesHistoryList')
<script src="{{asset('js/page_js/mr_sales_history_list.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.mrHistoryReportList')
<script src="{{asset('js/page_js/monthly_sales_history.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.medicalstoreHistoryReportList')
<script src="{{asset('js/page_js/medical_store_report.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.medicalstoreDoctorSalesReport')
<script src="{{asset('js/page_js/doctor_report.js')}}"></script>
@endif

@if (\Route::current()->getName() == 'admin.allRequestList')
<script src="{{asset('js/page_js/request_list.js')}}"></script>
@endif

<!-- Calendar JavaScript -->
<script src="{{ asset('js/evo-calendar.js') }}"></script>
