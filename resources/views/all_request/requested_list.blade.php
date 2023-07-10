@extends('layouts.admin')
@section('title','All Request')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Request</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     

		<div class="row">
		    <div class="col-12">
		        <div class="card">
		            <div class="card-body">
		                <form method="post" action="{{ route('admin.allRequestList') }}">
		                    @csrf
		                    <div class="form-row">
		                        <div class="col-md-6 mb-3">
		                            <label for="">Requested Date Range</label>
		                            <input type="text" class="form-control" name="request_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" @if(isset($request_date)) value="{{$request_date}}" @endif autocomplete="off">
		                        </div>
		                        <div class="col-md-6 mb-3">
		                            <label for="">Select Doctor</label>
		                            <input type="text" class="form-control doctor_suggestion" name="doctor_name" id="inputDoctor" placeholder="Doctor Name" @if(isset($doctor_name)) value="{{$doctor_name}}" @endif autocomplete="off">
                                	<input type="hidden" name="doctor_id" @if(isset($doctor_id)) value="{{$doctor_id}}" @endif class="doctor_id">
		                        </div>
		                    </div>
		                    <div class="form-row">
		                        <div class="col-md-6 mb-3">
		                            <label for="">Select MR</label>
		                            <input type="text" class="form-control mr_suggestion" id="inputMr" name="mr_name" placeholder="Mr Name" @if(isset($mr_name)) value="{{$mr_name}}" @endif autocomplete="off">
                                    <input type="hidden" name="mr_id" @if(isset($mr_id)) value="{{$mr_id}}" @endif class="mr_id">
		                        </div>
		                        <div class="col-md-6 mb-3">
		                            <label for="">Territorry</label>
		                            
                                    <input type="text" class="form-control territorry" name="territorry" id="territorry" placeholder="Territorry" @if(isset($territory)) value="{{$territory}}" @endif autocomplete="off">
                                    <input type="hidden" name="territorry_id" class="main_territory" @if(isset($territorry_id)) value="{{$territorry_id}}" @endif>
		                        </div>
		                    </div>

		                    <div class="form-row">
		                        <div class="col-md-6 mb-3">
		                            <label for="">Sub Territorry</label>
		                            <select class="form-control sub_territory" name="sub_territory">
		                               @forelse($get_sub_territory as $sk => $sv)
                                            <option value="{{$sv->id}}" @if($sub_territory == $sv->id) selected="selected" @endif >{{$sv->sub_territory}}</option>
                                        @empty
                                            
                                        @endforelse
		                            </select>
		                        </div>
		                        <div class="col-md-6 mb-3">
		                            <label for="">Request Status</label>
		                            <select class="form-control" name="status">
		                                <option value="">Status</option>
		                                <option value="0" @if(isset($status) && ($status == 0 && $status !='')) selected="selected" @endif >Pending</option>
		                                <option value="1" @if(isset($status) && ($status == 1)) selected="selected" @endif >Reject</option>
		                                <option value="2" @if(isset($status) && ($status == 2)) selected="selected" @endif >Approved</option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="form-row">
		                        <div class="col-md-6 mb-3">
		                            <label for="">Received by MR Status</label>
		                            <select class="form-control" name="received_status">
		                                <option value="">Select Status</option>
                                            <option @if(isset($received_status) && ($received_status == 0 && $received_status !='')) selected="selected" @endif value="0">Pending</option>
		                                    <option @if(($received_status) && ($received_status == 1)) selected="selected" @endif value="1">Received</option>
		                            </select>
		                        </div>
		                        <div class="col-md-6 mb-3">
		                            <label for="">Received Date Range</label>
		                            <input type="text" class="form-control" name="received_on" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" autocomplete="off" @if(isset($received_on)) value="{{$received_on}}" @endif >
		                        </div>
		                    </div>

		                    <div class="form-row">
		                        <div class="col-md-6 mb-3">
		                            <label for="">Doctor Payment Status</label>
		                            <select class="form-control" name="paid_to_doctor">
		                                <option value="">Select Payment Status</option>
		                                    <option @if(isset($paid_to_doctor) && ($paid_to_doctor == 0 && $paid_to_doctor !='')) selected="selected" @endif value="0">Pending</option>
		                                    <option @if(isset($paid_to_doctor) && ($paid_to_doctor == 1)) selected="selected" @endif value="1">Paid</option>
		                            </select>
		                        </div>
		                        <div class="col-md-6 mb-3">
		                            <label for="">Doctor Payment Date Range</label>
		                            <input type="text" class="form-control" name="payment_on" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="" @if(isset($payment_on)) value="{{$payment_on}}" @endif autocomplete="off">
		                        </div>
		                    </div>

		                    <div class="form-row">
		                        <div class="col-md-2 mt-4">
		                            <button type="submit" class="btn btn-primary vendors save_button">Submit</button>
		                        </div>
		                    @if(isset($filter) && ($filter == 1))
		                        <div class="col-md-1 mt-4" style="margin-left: 2%;margin-top: 1.3rem!important">
		                            <a href="{{ route('admin.allRequestList') }}" class="btn btn-danger mt-1 cancel_button" id="filter" name="save_and_list" value="save_and_list" style="margin-left: -100px;">Reset</a>
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
                                    <th>Doctor Name</th>
                                    <th>Requested Date</th>
                                    <th>Requested Amount</th>
                                    <th>Territories</th>
                                    <th>Submitted By</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment On</th>
                                    <th>Received By MR</th>
                                    <th>Received On</th>
                                    <th>Paid to Doctor</th>
                                    <th>Paid On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@forelse($get_all_request as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv['doctor_detail']['full_name'] }} @if(!empty($gv['profile_detail']) && ($gv['profile_detail']['profile_name'] != '')) ( {{ $gv['profile_detail']['profile_name'] }} )  @endif</td>                                     
                                        <td>{{ $gv->request_date != '' ? date('d/m/Y',strtotime($gv->request_date)) : '' }}</td>

                                        <td>{{ $gv->request_amount != '' ? $gv->request_amount : '' }}</td>

                                        @if(!is_null($gv['main_territory_detail']))
                                        @php $stops = array(); @endphp
                                        @php $unique_stops = array(); @endphp
                                            @foreach($gv['main_territory_detail'] as $sk => $sv)
                                                @if(!empty($sv['territory_name']))
                                                    @if(!in_array($sv['territory_name']['territory_id'],$unique_stops))
                                                        @php $unique_stops[] =  $sv['territory_name']['territory_id']; @endphp
                                                       @php $stops[] = $sv['territory_name']['territory_id']; @endphp 
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td>{{ implode(' | ',$stops) }}</td>
                                        @else
                                            <td> -------- </td>
										@endif
										
                                        <td>{{ $gv['mr_detail'] != '' ? $gv['mr_detail']['full_name'] : '' }}</td>

                                        <td>{{ ($gv->status == 0) ? 'Pending' : (($gv->status == 1) ? 'Reject' : 'Approve') }}</td>

                                        @if($gv->status == 0 || $gv->status == 1)
                                        	<td> ------ </td>
                                        @else
                                        <td>
                                            <?php $current_date = date("d/m/Y"); ?>
                                        	<select class="form-control payment_genrated payment_genrated_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif >
                                                <option @if(isset($gv->is_payment_genrated) &&  ($gv->is_payment_genrated == 0)) selected="selected" @endif value="0" >Pending</option>
                                                <option @if(isset($gv->is_payment_genrated) &&  ($gv->is_payment_genrated == 1)) selected="selected" @endif value="1" >Done</option>
                                            </select>
                                        </td>
                                        @endif

                                        <td class="payment_date_{{$gv->id}}">{{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->payment_on != ''  && $gv->payment_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->payment_on)) : '-----') }}</td>

                                        @if($gv->status == 0 || $gv->status == 1)
                                        	<td> ------ </td>
                                        @else
                                        	<td>
                                                <?php $current_date = date("d/m/Y"); ?>
	                                        	<select class="form-control received_by_mr received_by_mr_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif>
	                                                <option @if(isset($gv->received_by_mr) &&  ($gv->received_by_mr == 0)) selected="selected" @endif value="0" >Pending</option>
	                                                <option @if(isset($gv->received_by_mr) &&  ($gv->received_by_mr == 1)) selected="selected" @endif value="1" >Received</option>
	                                            </select>
	                                        </td>
                                       	@endif

                                        <td class="receive_mr_date_{{$gv->id}}"> {{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->received_on != ''  && $gv->received_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->received_on)) : '-----') }}</td>


                                        @if($gv->status == 0 || $gv->status == 1)
                                        	<td> ------ </td>
                                        @else
                                        	<td>
                                                <?php $current_date = date("d/m/Y"); ?>
	                                        	<select class="form-control paid_to_doctor paid_to_doctor_{{$gv->id}}" data-id="{{$gv->id}}" data-date="{{$current_date}}" @if($gv->is_paid_to_doctor == 1) disabled="disabled" @endif>
	                                                <option @if(isset($gv->is_paid_to_doctor) &&  ($gv->is_paid_to_doctor == 0)) selected="selected" @endif value="0" >Pending</option>
	                                                <option @if(isset($gv->is_paid_to_doctor) &&  ($gv->is_paid_to_doctor == 1)) selected="selected" @endif value="1" >Paid</option>
	                                            </select>
	                                        </td>
                                        @endif

                                        <td class="paid_doctor_date_{{$gv->id}}">{{ ($gv->status == 0 || $gv->status == 1) ? '-----' : (($gv->paid_on != ''  && $gv->paid_on != '0000-00-00') ? date('d/m/Y',strtotime($gv->paid_on)) : '-----') }}</td>

                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.viewDoctorRequest',$gv->id) }}" role="button" title="View Request"><i class="bx bx-show-alt"></i></a>
                                        </td>
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