@extends('layouts.admin')
@section('title','Monthly Mr Sales History')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ date('F Y',strtotime($get_mr_territories->sales_month)) }} : {{$get_mr_territories['mr_detail']['full_name']}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monthly Mr Sales History</li>
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
                                    <th>Stockiest</th>
                                    <th>Amount</th>
                                    <th>Submitted On</th>   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_stockiest_data))
                                @foreach($get_stockiest_data as $gk => $gv)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{$gv['stockiest_detail']['stockiest_name']}} </td>
                                        <td>

                                            <input type="text" class="form-control number change_amount amount_{{$gv->id}}" name="brand_priority" autocomplete="off" data-id="{{$gv->id}}" @if($gv->amount != '') data-value="{{$gv->amount}}" value="{{$gv->amount}}" @endif>

                                            <div class="editable-buttons save_{{$gv->id}}" style="display: none;">
                                                <button type="button" class="btn btn-primary btn-sm mt-1 add_amount add_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-check font-size-12"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1 remove_amount remove_{{$gv->id}}" data-id="{{$gv->id}}" ><i class="mdi mdi-close font-size-12 "></i></button>
                                            </div>

                                        </td>

                                        <td><center> {{ $gv->submitted_on != '' ? date('d/m/Y',strtotime($gv->submitted_on)) : '-----' }} </center></td>

                                        <td>
                                            
                                            <a class="btn btn-primary waves-effect waves-light statement" href="{{ route('admin.medicalstoreHistoryReportList',[$gv->id,$gv->mr_id]) }}" role="button"><i class="bx bx-trending-up"></i></a>

                                            <a class="btn btn-primary waves-effect waves-light statement" href="javascript:void(0);" data-toggle="modal" data-target="#example_02" data-id="{{$gv->id}}" role="button"><i class="bx bx-notepad"></i></a>
                                            
                                            <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.deleteStockiestData',[$gv->id,$gv->mr_id]) }}" role="button" onclick="return confirm('Do you want to clear this data?');"><i class="bx bx-trash-alt"></i></a>

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
<div class="modal fade" id="example_02" tabindex="-1" role="dialog" aria-labelledby="example_02" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalcontent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button> -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

</script>
@endsection