@extends('layouts.admin')
@section('title','Monthly Medical Store History')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{$get_stockiest_detail['mr_detail']['mr_detail']['full_name']}} : {{$get_stockiest_detail['stockiest_detail']['stockiest_name']}} ({{ date('F Y',strtotime($get_stockiest_detail->sales_month)) }})</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monthly Medical Store History</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Medical Store</th>
                                    <th>Sales Amount</th>
                                    <th>Extra Business</th>
                                    <th>Scheme Business</th>
                                    <th>Ethical Business</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_medical_store_data))
                                @foreach($get_medical_store_data as $gk => $gv)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{$gv['store_detail']['store_name']}} </td>
                                        <td>

                                            <input type="text" class="form-control number sales_amount amount_sales_{{$gv->id}}" name="sales_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->sales_amount != '') data-value="{{$gv->sales_amount}}" value="{{$gv->sales_amount}}" @endif>

                                            <div class="editable-buttons sales_button_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_sales_amount add_{{$gv->id}}" data-id="{{$gv->id}}" data-store="{{$get_stockiest_detail->id}}"><i class="mdi mdi-check font-size-12"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_sales_amount remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i></button>
                                            </div>

                                        </td>

                                        <td>

                                            <input type="text" class="form-control number extra_business amount_extra_business_{{$gv->id}}" name="sales_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->extra_business != '') data-value="{{$gv->extra_business}}" value="{{$gv->extra_business}}" @endif>

                                            <div class="editable-buttons extra_business_button_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_extra_business add_{{$gv->id}}" data-id="{{$gv->id}}" data-store="{{$get_stockiest_detail->id}}"><i class="mdi mdi-check font-size-12"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_extra_business remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i></button>
                                            </div>

                                        </td>

                                        <td>

                                            <input type="text" class="form-control number scheme_business amount_scheme_business_{{$gv->id}}" name="sales_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->scheme_business != '') data-value="{{$gv->scheme_business}}" value="{{$gv->scheme_business}}" @endif>

                                            <div class="editable-buttons scheme_business_button_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_scheme_business add_{{$gv->id}}" data-id="{{$gv->id}}" data-store="{{$get_stockiest_detail->id}}"><i class="mdi mdi-check font-size-12"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_scheme_business remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i></button>
                                            </div>

                                        </td>

                                        <td>

                                            <input type="text" class="form-control number ethical_business amount_ethical_business_{{$gv->id}}" name="sales_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->ethical_business != '') data-value="{{$gv->ethical_business}}" value="{{$gv->ethical_business}}" @endif>

                                            <div class="editable-buttons ethical_business_button_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_ethical_business add_{{$gv->id}}" data-id="{{$gv->id}}" data-store="{{$get_stockiest_detail->id}}"><i class="mdi mdi-check font-size-12"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_ethical_business remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i></button>
                                            </div>

                                        </td>
                                        <td>
                                            
                                            <a class="btn btn-primary waves-effect waves-light statement" href="{{ route('admin.medicalstoreDoctorSalesReport',[$gv->id,$gv->stockiest_id,$gv->mr_id]) }}" role="button"><i class="bx bx-trending-up"></i></a>
                                            
                                            <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.deleteMedicalStoreData',[$gv->id,$gv->stockiest_id,$gv->mr_id]) }}" role="button" onclick="return confirm('Do you want to clear this data?');"><i class="bx bx-trash-alt"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- Statement -->

@endsection
@section('js')
<script>

</script>
@endsection