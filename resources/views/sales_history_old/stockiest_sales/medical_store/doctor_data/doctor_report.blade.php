@extends('layouts.admin')
@section('title','Monthly Doctor History')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        @if(isset($get_stockiest_detail['mr_detail']['mr_detail']['full_name'])) {{$get_stockiest_detail['mr_detail']['mr_detail']['full_name']}} : @endif 
                        @if(isset($get_stockiest_detail['store_detail']['store_name']))
                        {{$get_stockiest_detail['store_detail']['store_name']}} @endif
                        @if(isset($get_stockiest_detail->sales_month))
                        ({{ date('F Y',strtotime($get_stockiest_detail->sales_month)) }})
                        @endif
                    </h4>
                    


                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monthly Doctor History</li>
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
                                    <th>Doctor Name</th>
                                    <th>Sales Amount</th>
                                    <!-- <th>Status</th>
                                    <th>Conformation Status</th>
                                    <th>Confirm By</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_medical_store_data))
                                @foreach($get_medical_store_data as $gk => $gv)
                                    
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{$gv['doctor_detail']['full_name']}} @if(isset($gv['profile_detail']['profile_name'])) ( {{$gv['profile_detail']['profile_name']}} )  @endif</td>
                                        <!-- <td><input class="form-control number" type="text" id="example-text-input"></td> -->

                                        <td>

                                            <input type="text" class="form-control number change_amount amount_{{$gv->id}}" name="brand_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->sales_amount != '') data-value="{{$gv->sales_amount}}" value="{{$gv->sales_amount}}" @endif>

                                            <div class="editable-buttons save_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_amount add_{{$gv->id}}" data-id="{{$gv->id}}" @if(isset($get_stockiest_detail->id)) data-store="{{$get_stockiest_detail->id}}" @endif><i class="mdi mdi-check font-size-12"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_amount remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i>
                                                </button>
                                            </div>

                                        </td>

                                        <!-- <td> {{ $gv->submitted_on != '' ? date('d-m-Y',strtotime($gv->submitted_on)) : '' }} </td> -->

                                        <td>
                                            
                                            <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.deleteDoctorData',[$gv->id,$gv->medical_store_id,$gv->stockiest_id,$gv->mr_id]) }}" role="button" onclick="return confirm('Do you want to clear this data?');"><i class="bx bx-trash-alt"></i></a>

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