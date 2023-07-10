@extends('layouts.admin')
@section('title','Edit Stockiest')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Stockiest</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Stockiest</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveEditedStockiest') }}" method="post" id="stockiestForm" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Stockiest Details</h4>

                            <div class="form-group">
                                <label>Stockiest Name <span class="mandatory">*</span></label>
                                <input type="text" class="form-control" name="stockiest_name" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" placeholder="Stockiest Name" value="{{$get_stockiest_detail->stockiest_name}}" autocomplete="off" required/>
                                <input type="hidden" name="id" id="stockiest_id" value="{{$get_stockiest_detail->id}}">
                            </div>
                            <!-- onkeypress="return /[a-z]/i.test(event.key)" -->
                            <div class="form-group">
                                <label>Stockiest Address </label>
                                <textarea class="form-control" name="stockiest_address" id="stockiest_address" placeholder="Stockiest Address" autocomplete="off" >{{$get_stockiest_detail->stockiest_name}}</textarea>
                            </div>

                             <div class="form-group">
                                <label>Stockiest Phone Number </label>
                                <input type="text" class="form-control number" name="stockiest_phone_number" placeholder="Stockiest Phone Number" autocomplete="off" maxlength="10" minlength="10" value="{{$get_stockiest_detail->stockiest_phone_number}}" />
                            </div>

                            <div class="form-group">
                                <label>Stockiest Email ID </label>
                                <input type="email" class="form-control" name="stockiest_email_id" placeholder="Stockiest Email ID" value="{{$get_stockiest_detail->store_email_id}}" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>GST Number </label>
                                <input type="text" class="form-control alphanumeric" name="gst_number" value="{{$get_stockiest_detail->gst_number}}" placeholder="GST Number" maxlength="15" minlength="15" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Territories</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Territories <span class="mandatory">*</span></label>
                                    <select class="select2 form-control select2-multiple territories" multiple="multiple" name="territories[]" data-placeholder="" required>
                                        @forelse ($get_all_territory as $gk => $gv)
                                            <option value="{{$gv->id}}" @if(in_array($gv->id,$terretory_id)) selected="selected" @endif >{{$gv->territory_id}}</option>
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
                                    </select>
                                    <span id="territories"></span>
                                </div>
                            </div><br><br>
                            <div class="row">    
                                <div class="col-md-12">
                                    <label>Sub Territories <span class="mandatory">*</span></label>
                                    <select class="select2 form-control select2-multiple sub_territories" multiple="multiple" name="sub_territories[]" data-placeholder="" required>
                                        @forelse ($get_sub_territory as $sk => $sv)
                                            <option value="{{$sv->id}}" @if(in_array($sv->id,$sub_terretory_id)) selected="selected" @endif >{{$sv->sub_territory}}</option>
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
                                    </select>
                                    <span id="sub_territories"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body row">
                            <div class="form-group col-md-6">
                                <label for="inputUserName">User Name</label>
                                <input type="text" class="form-control character" id="inputUserName" placeholder="User Name" autocomplete="off">
                                <input type="hidden" class="added_user_id" value="{{ json_encode($user_id) }}">
                            </div>
                            <div class="form-group col-md-6" style="margin-top: 1.8rem!important">
                                <a href="javascript:void(0);" class="btn btn-info addNewUser save_button">Add</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card"> -->
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="m-b-0">
                                <i class="mdi mdi-checkbox-intermediate"></i> Users
                            </h5>

                        </div>
                        <div class="card-body" style="overflow-x:auto;">
                            <table  class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Engagement Type</th>
                                        <th>Role</th>
                                        <th>Email ID</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userData">
                                @if(!is_null($get_stockiest_detail['stockiest_user']))
                                    @foreach($get_stockiest_detail['stockiest_user'] as $guk => $guv)
                                    <tr class="user_dynamic_row">
                                        <td><center>{{ $guv['stockiest_user_detail']['name'] }}</center></td>
                                        <td><center>{{ $guv['stockiest_user_detail']['email'] }}</center></td>
                                        <td><center>{{ $guv['stockiest_user_detail']['mobile']  }}</center></td>
                                        <input type="hidden" name="data[{{ $guv['id'] }}][id]" value="{{$guv['stockiest_user_detail']['id']}}">
                                        <input type="hidden" name="data[{{ $guv['id'] }}][name]" value="{{$guv['stockiest_user_detail']['name']}}">
                                        <input type="hidden" name="data[{{ $guv['id'] }}][mobile]" value="{{$guv['stockiest_user_detail']['mobile']}}">
                                        <input type="hidden" name="data[{{ $guv['id'] }}][email]" value="{{$guv['stockiest_user_detail']['email']}}">
                                        <td>
                                            <center>
                                                <select name="data[{{ $guv['id'] }}][engagement_type]" class="form-control" style="width: 208px;" data-msg="Plese Select Engagement Type" required>
                                                    <option value="">Select Engagement Type</option>
                                                    <option value="1" @if($guv['engagement_type'] == 1) selected="selected" @endif>Primary</option>
                                                    <option value="2" @if($guv['engagement_type'] == 2) selected="selected" @endif>Secondary</option>
                                                </select>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <select name="data[{{ $guv['id'] }}][role]" class="form-control" style="width: 160px;" data-msg="Plese Select Role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="1" @if($guv['role'] == 1) selected="selected" @endif>Owner</option>
                                                    <option value="2" @if($guv['role'] == 2) selected="selected" @endif>Employee</option>
                                                </select>
                                            </center>
                                        </td>
                                        <td><a href="javascript:void(0);" class="btn btn-danger deleteThisRow cancel_button" data-id="{{ $guv['id'] }}"><i class="bx bx-trash-alt"></i></a></td>
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- </div> -->
                </div> <!-- end col -->
            
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div>
                                    <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Update
                                    </button>
                                    <a href="{{ route('admin.stockiestList') }}" class="btn btn-secondary waves-effect cancel_button">
                                        Cancel
                                    </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>


</script>
@endsection