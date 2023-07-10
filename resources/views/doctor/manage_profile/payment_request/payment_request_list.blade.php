@extends('layouts.admin')
@section('title','Payment Request')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Payment Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment Request</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Sales of {{$last_month_heading}}</p>
                                <h4 class="mb-0">₹ {{$last_month_sales}}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center save_and_next_button">
                                <span class="avatar-title save_and_next_button">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Sales of {{$second_month_heading}}</p>
                                <h4 class="mb-0">₹ {{$second_month_sales}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title save_and_next_button">
                                    <i class="bx bx-archive-in font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Sales of {{$third_month_heading}}</p>
                                <h4 class="mb-0">₹ {{$third_month_sales}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title save_and_next_button">
                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Target Sales</p>
                            <!-- <p class="text-muted font-weight-medium">Target Sales of {{$target_sales_heading}}</p> -->
                            <h4 class="mb-0">₹ {{ number_format($target_sales,2)}}</h4>
                        </div>

                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center save_and_next_button">
                            <span class="avatar-title save_and_next_button">
                                <i class="bx bx-copy-alt font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Carry Forward Points</p>
                                <!-- <p class="text-muted font-weight-medium">Carry Forward Points of {{$carry_forward_heading}}</p> -->
                                <h4 class="mb-0">₹ {{  number_format($carry_forward_sales,2) }}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title save_and_next_button">
                                    <i class="bx bx-archive-in font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">

                                <p class="text-muted font-weight-medium">Eligible Points</p>
                                <!-- <p class="text-muted font-weight-medium">Eligible Points of {{$eligible_heading}}</p> -->
                                <h4 class="mb-0">₹ {{ number_format($eligible_sales,2)}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title save_and_next_button">
                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.doctorRequestList',[$doctor_id,$id]) }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Requested Date Range</label>
                                    <input type="text" class="form-control" name="request_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" @if(isset($request_date)) value="{{$request_date}}" @endif  autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Received Date Range</label>
                                    <input type="text" class="form-control" name="received_on" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" @if(isset($received_on)) value="{{$received_on}}" @endif autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Doctor Payment Date Range</label>
                                    <input type="text" class="form-control" name="payment_on" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" @if(isset($payment_on)) value="{{$payment_on}}" @endif autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Request Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Status</option>
                                        <option value="0" @if(isset($status) && ($status == 0)) selected="selected" @endif >Pending</option>
                                        <option value="1" @if(isset($status) && ($status == 1)) selected="selected" @endif >Reject</option>
                                        <option value="2" @if(isset($status) && ($status == 2)) selected="selected" @endif >Approved</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button">Submit</button>
                                </div>
                            @if(isset($filter) && ($filter == 1))
                                <div class="col-md-1 mt-4" style="margin-left: 2%;margin-top: 1.3rem!important">
                                    <a href="{{ route('admin.doctorRequestList',[$doctor_id,$id]) }}" class="btn btn-danger mt-1" id="filter" name="save_and_list" value="save_and_list" style="margin-left: -100px;">Reset</a>
                                </div>
                            @endif
                            </div>
                        </form>
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
                                    <th>Requested Date</th>
                                    <th>Requested Points</th>
                                    <th>Reason</th>
                                    <th>Requested Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment On</th>
                                    <th>Received By MR</th>
                                    <th>Received On</th>
                                    <th>Paid to Doctor</th>
                                    <th>Paid On</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            	@forelse($doctor_payment as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->request_date != '' ? date('d/m/Y',strtotime($gv->request_date)) : '' }}</td>
                                        <td>{{ $gv->request_amount != '' ? $gv->request_amount : '' }}</td>
                                        <td>{{ $gv->reason != '' ? $gv->reason : '' }}</td>
                                        <!-- <td>{{ ($gv->status == 0) ? 'Pending' : (($gv->status == 1) ? 'Reject' : 'Approve') }}</td> -->

                                        <td>
                                            <select class="form-control status" data-id="{{$gv->id}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif >
                                                <option @if(isset($gv->status) &&  ($gv->status == 0)) selected="selected" @endif value="0">Pending</option>
                                                <option @if(isset($gv->status) &&  ($gv->status == 1)) selected="selected" @endif value="1" >Reject</option>
                                                <option @if(isset($gv->status) &&  ($gv->status == 2)) selected="selected" @endif value="2" >Approve</option>
                                            </select>
                                        </td>

                                        @if($gv->status == 0 || $gv->status == 1)
                                            <td> ------ </td>
                                        @else
                                            <td class="option_{{$gv->id}}">
                                                <?php $current_date = date("d/m/Y"); ?>
                                                <select class="form-control payment_genrated payment_genrated_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif >
                                                    <option @if(isset($gv->is_payment_genrated) &&  ($gv->is_payment_genrated == 0)) selected="selected" @endif value="0" >Pending</option>
                                                    <option @if(isset($gv->is_payment_genrated) &&  ($gv->is_payment_genrated == 1)) selected="selected" @endif value="1" >Done</option>
                                                </select>
                                            </td>
                                            <td class="option_other_{{$gv->id}}" style="display:none;"> ------ </td>
                                        @endif

                                        <td class="payment_date_{{$gv->id}}">{{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->payment_on != ''  && $gv->payment_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->payment_on)) : '-----') }}</td>

                                        @if($gv->status == 0 || $gv->status == 1)
                                        	<td> ------ </td>
                                        @else
                                        	<td class="option_{{$gv->id}}">
                                                <?php $current_date = date("d/m/Y"); ?>
	                                        	<select class="form-control received_by_mr received_by_mr_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif>
	                                                <option @if(isset($gv->received_by_mr) &&  ($gv->received_by_mr == 0)) selected="selected" @endif value="0" >Pending</option>
	                                                <option @if(isset($gv->received_by_mr) &&  ($gv->received_by_mr == 1)) selected="selected" @endif value="1" >Received</option>
	                                            </select>
	                                        </td>
                                            <td class="option_other_{{$gv->id}}" style="display:none;"> ------ </td>
                                       	@endif

                                        <td class="receive_mr_date_{{$gv->id}}"> {{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->received_on != ''  && $gv->received_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->received_on)) : '-----') }}</td>

                                        @if($gv->status == 0 || $gv->status == 1)
                                        	<td> ------ </td>
                                        @else
                                        	<td class="option_{{$gv->id}}">
                                                <?php $current_date = date("d/m/Y"); ?>
	                                        	<select class="form-control paid_to_doctor paid_to_doctor_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif>
	                                                <option @if(isset($gv->is_paid_to_doctor) &&  ($gv->is_paid_to_doctor == 0)) selected="selected" @endif value="0" >Pending</option>
	                                                <option @if(isset($gv->is_paid_to_doctor) &&  ($gv->is_paid_to_doctor == 1)) selected="selected" @endif value="1" >Paid</option>
	                                            </select>
	                                        </td>
                                            <td class="option_other_{{$gv->id}}" style="display:none;"> ------ </td>
                                        @endif

                                        <td class="paid_doctor_date_{{$gv->id}}">{{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->paid_on != ''  && $gv->paid_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->paid_on)) : '-----') }}</td>
                                        
                                        <!-- <td>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.viewDoctorRequest',$gv->id) }}" role="button"><i class="bx bx-show-alt"></i></a>
                                        </td> -->
                                    </tr>
                            	@empty	
                            		
                            	@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
@section('js')
<script>


</script>
@endsection