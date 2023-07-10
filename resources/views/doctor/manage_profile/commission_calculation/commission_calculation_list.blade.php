@extends('layouts.admin')
@section('title','Commission Calculation')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    @if(isset($doctor_details->profile_name) && ($doctor_details->profile_name != ''))
                        <h4 class="mb-0 font-size-18">Commission : {{$doctor_details['doctor_detail']['full_name']}} ( {{$doctor_details->profile_name}} )</h4>
                    @else
                        <h4 class="mb-0 font-size-18">Commission : {{$doctor_details['doctor_detail']['full_name']}}</h4>
                    @endif

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.doctorList') }}">Doctor List</a></li>
                            <li class="breadcrumb-item active">Commission Calculation</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>    
        <!-- end page title -->
        <form class="custom-validation" action="{{ route('admin.saveDoctorCommision') }}" class="commission_form" method="post" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">

                        <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{route('admin.doctorManageProfile',$doctor_id)}}" role="button" title="Back to Profile" style="float:left;"> Back to Profile</a>

                        <a class="btn btn-primary waves-effect waves-light add_commission_btn save_and_next_button" href="javascript:void(0);" role="button" title="Add Commission" style="float:right;"><i class="bx bx-plus"></i> Add Reward</a><br><br><br>
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reward %</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr class="add_commission" style="display: none;">
                                    <td>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control new_start_date" name="new_start_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" value="{{date('d/m/Y')}}" autocomplete="off">
                                        <span class="new_start_date_error" style="color: red; display: none;"></span>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control new_end_date" name="new_end_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy"  autocomplete="off">
                                    </td>
                                    <input type="hidden" name="doctor_id" value="{{$doctor_details->doctor_id}}">
                                    <input type="hidden" name="profile_id" value="{{$id}}">
                                    <td> 
                                        <input type="text" class="form-control number new_commission" name="new_commission" placeholder="Reward" autocomplete="off" autocomplete="off" maxlength='3'/>
                                        <span class="new_commission_error" style="color: red; display: none;"></span>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 submit save_button" name="btn_submit" title="Add Reward" value="save">
                                            <i class="bx bx-plus"></i>Add
                                        </button>
                                        <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteDoctorProfile',$id) }}" role="button" title="Remove Commission" onclick="return confirm('Do you want to delete this doctor reward?');"><i class="bx bx-trash-alt"></i></a>
                                    </td>

                                </tr>
                                <?php $i=1;  ?>
                                @forelse($get_commission as $gk => $gv)
                                <tr>
                                    <td>
                                        <?php echo $i;?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control start_date_{{$gv->id}} commission_start_date  last_id " name="start_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-id="{{$gv->id}}" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-end-date="0d" autocomplete="off" value="{{ date('d/m/Y', strtotime($gv->start_date)) }}">
                                        <span class="start_date_error_{{$gv->id}}" style="color: red; display: none;"></span>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control end_date_{{$gv->id}} commission_end_date" name="end_date" placeholder="dd/mm/yyyy" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" autocomplete="off" @if(isset($gv->end_date) && ($gv->end_date != '')) value="{{ date('d/m/Y', strtotime($gv->end_date)) }}" @endif>
                                        <!-- <span class="end_date_error_{{$gv->id}}" style="color: red; display: none;"></span> -->
                                     </td>
                                    @if(isset($gv->id) && ($gv->id != ''))
                                        <input type="hidden" name="id" value="{{$gv->id}}">
                                    @endif
                                    <input type="hidden" name="doctor_id" value="{{$doctor_details->doctor_id}}">
                                    <input type="hidden" name="profile_id" value="{{$id}}">
                                    <td class="team">
                                        <input type="text" class="form-control number update_commission commission_{{$gv->id}}" name="commission" placeholder="Reward" autocomplete="off" value="{{$gv->commission}}" required autocomplete="off" data-id="{{$gv->id}}" />
                                        <span class="commission_error_{{$gv->id}}" style="color: red; display: none;"></span>
                                    </td>
                                    <td>
                                        <button type="button" data-id="{{$gv->id}}" data-doctor="{{$gv->doctor_id}}" data-profile="{{$gv->profile_id}}" class="btn btn-primary waves-effect waves-light mr-1 update_commission save_and_next_button" title="Update Reward" name="btn_submit" value="save">
                                            <i class="bx bx-plus"></i>Update
                                        </button>
                                        
                                        <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteDoctorCommission',[$doctor_id,$id,$gv->id]) }}" role="button" title="Remove Reward" onclick="return confirm('Do you want to delete this doctor reward?');"><i class="bx bx-trash-alt"></i></a>

                                    </td>

                                </tr>
                                <?php $i++;?>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </form>
    </div> <!-- container-fluid -->
</div>

@endsection
@section('js')
<script>


</script>
@endsection