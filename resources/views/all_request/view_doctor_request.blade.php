@extends('layouts.admin')
@section('title','View Doctor Details')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ $get_doctor_details['doctor_detail']['full_name'] }} ( {{ $get_doctor_details->request_date }} ) - {{ $get_doctor_details['mr_detail']['full_name'] }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">View Doctor Details</li>
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

                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
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
                            <h4 class="mb-0">₹ {{$target_sales}}</h4>
                        </div>

                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
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
                                <p class="text-muted font-weight-medium">Carry Forward Amount</p>
                                <h4 class="mb-0">₹ {{$carry_forward_sales}}</h4>
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
                                <p class="text-muted font-weight-medium">Eligible Amount</p>
                                <h4 class="mb-0">₹ {{$eligible_sales}}</h4>
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
        
        <form action="{{route('admin.updateStatusPayment')}}" method="post">
        @csrf
	        <div class="row">
	        	<div class="col-2">
	        	</div>
	        	<div class="col-8">
	                <div class="card">
	                    <div class="card-body">	
	                    	<div class="form-group row">
	                            <label for="example-text-input" class="col-md-4 col-form-label">Request Amount</label>
	                            <div class="col-md-6">
	                                <input class="form-control" type="text" readonly="readonly" @if(isset($get_doctor_details->request_amount) && ($get_doctor_details->request_amount != '')) value="{{$get_doctor_details->request_amount}}" @endif id="example-text-input">
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <label for="example-text-input" class="col-md-4 col-form-label">Reason</label>
	                            <div class="col-md-6">
	                                <textarea class="form-control" rows="5" readonly="readonly"> @if(isset($get_doctor_details->reason) && ($get_doctor_details->reason != '')) {{$get_doctor_details->reason}} @endif </textarea>
	                            </div>
	                        </div>

	                    </div>
	                </div>
	            </div>
	            <div class="col-md-2">
	            </div>
		    </div>
		   	<div class="row">
		        <div class="col-2">
		        </div>
		            <div class="col-8">
		            	<input type="hidden" name="id" value="{{$get_doctor_details->id}}">
		            	<center>
                        @if($get_doctor_details->is_paid_to_doctor == 0)
                            @if($get_doctor_details->status == 1)
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save" name="status" value="2">
                                Approve
                            </button>
                            @endif
                            @if($get_doctor_details->status == 2)
                            <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next" name="status" value="1">
                                Reject
                            </button>
                            @endif

                            @if($get_doctor_details->status == 0)
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save" name="status" value="2">
                                Approve
                            </button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next" name="status" value="1">
                                Reject
                            </button>
                            @endif
                        @endif
                        <a href="{{route('admin.allRequestList')}}" class="btn btn-secondary waves-effect cancel_button">
                            Cancel
                        </a>

	                    </center>
	                </div>
	          	<div class="col-md-2">
	           	</div>  
	        </div>
        </form>
    </div>
</div>
@endsection
@section('js')

@endsection