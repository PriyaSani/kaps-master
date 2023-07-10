@extends('layouts.admin')
@section('title','Manage Profile')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Manage Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.doctorList') }}">Doctor List</a></li>
                            <li class="breadcrumb-item active">Manage Profile</li>
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
                                <h4 class="mb-0">₹ {{array_sum($last_month_sales)}}</h4>
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
                                <h4 class="mb-0">₹ {{array_sum($previous_sales_data)}}</h4>
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
                                <h4 class="mb-0">₹ {{array_sum($previous_third_sales_data)}}</h4>
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
                            <h4 class="mb-0">₹ {{ number_format(array_sum($target_sales_data),2) }}</h4>
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
                                <p class="text-muted font-weight-medium">Carry Forward Points</p>

                                <h4 class="mb-0">₹ {{ number_format(array_sum($carry_sales_data),2) }}</h4>
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
                                <h4 class="mb-0">₹ {{ number_format(array_sum($eligible_sales_data),2) }}</h4>
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
                <b><h4 class="font-size-16">Doctor Name : {{$get_doctor->full_name}}</h4></b>
                <div class="card">
                    <form class="custom-validation" action="{{ route('admin.saveDoctorProfile') }}" method="post" id="saveDoctorProfile" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-sm-6">
                                    <input type="text" class="form-control" name="profile_name" placeholder="Profile Name" autocomplete="off"  required >
                                    <input type="hidden" name="doctor_id" id="id" value="{{ $get_doctor->id }}">
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_and_next_button" name="btn_submit" value="save"><i class="bx bx-plus"></i>
                                        Add Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Doctor Profile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;  ?>
                                @forelse($get_profiles as $gk => $gv)

                                    <tr>
                                        <td><?php echo $i;?></td>
                                        @if($gv->profile_name != '')
                                            <td>{{$gv['doctor_detail']['full_name']}} ( {{$gv->profile_name}} )</td>
                                        @else

                                            <td>{{$gv['doctor_detail']['full_name']}}</td>
                                        @endif
                                        <td>

                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.doctorRequestList',[$gv->doctor_id,$gv->id]) }}" title="Doctor Request" role="button"><i class="bx bx-log-in-circle"></i></a>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.doctorSalesList',[$gv->doctor_id,$gv->id]) }}" title="Doctor Sales" role="button"><i class="bx bx-align-left"></i></a>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.doctorCommision',[$gv->doctor_id,$gv->id]) }}" title="Doctor Rewards" role="button"><i class="bx bx-calculator"></i></a>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.doctorOffset',[$gv->doctor_id,$gv->id]) }}" title="Add Offset" role="button"><i class="bx bx-paste"></i></a>
                                            
                                        @if($gv->profile_name != '')
                                            <a class="btn btn-primary waves-effect waves-light update_profile save_and_next_button" href="javascript:Void(0);" data-id="{{$gv->doctor_id}}" title="Edit Profile" data-value="{{$gv->id}}" data-toggle="modal" data-target="#example_02" role="button"><i class="bx bx-pencil"></i></a>

                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteDoctorProfile',[$gv['doctor_detail']['id'],$gv->id]) }}" title="Remove Profile" role="button" onclick="return confirm('Do you want to delete this doctor profile?');"><i class="bx bx-trash-alt"></i></a>
                                        @endif
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

    </div> <!-- container-fluid -->
</div>
<div class="modal fade"  id="example_02" tabindex="-1" role="dialog" aria-labelledby="example_02" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modalcontent">
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary cancel_button" data-dismiss="modal">
                Close
            </button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection