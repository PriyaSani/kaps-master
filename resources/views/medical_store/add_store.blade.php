@extends('layouts.admin')
@section('title','Add Medical Store')
@section('content')
<style type="text/css">
#upload-demo{
    width: 250px;
    height: 250px;
    padding-bottom:25px;
}
</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Medical Store</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Medical Store</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.saveStore') }}" method="post" id="medicalStoreForm" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4>
                            <h4 class="card-title mb-4">Store Details</h4>

                            <div class="form-group">
                                <label>Store Name <span class="mandatory">*</span></label>
                                <input type="text" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" class="form-control" name="store_name" placeholder="Store Name" autocomplete="off" required/>
                            </div>

                            <div class="form-group">
                                <label>Store Address </label>
                                <textarea class="form-control" name="store_address" id="store_address" placeholder="Store Address" autocomplete="off" ></textarea>
                            </div>

                             <div class="form-group">
                                <label>Store Phone Number </label>
                                <input type="text" class="form-control number" name="store_phone_number" placeholder="Store Phone Number" autocomplete="off" maxlength="10" minlength="10" />
                            </div>

                            <div class="form-group">
                                <label>Store Email ID </label>
                                <input type="email" class="form-control" name="store_email_id" placeholder="Store Email ID" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>GST Number </label>
                                <input type="text" class="form-control alphanumeric" name="gst_number" maxlength="15" minlength="15" placeholder="GST Number" autocomplete="off" />
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
                                        @forelse ($get_territories as $gk => $gv)
                                            <option value="{{$gv->id}}">{{$gv->territory_id}}</option>
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
                                <input type="text" class="form-control character" id="inputUserName" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" placeholder="User Name" autocomplete="off">
                                <input type="hidden" class="added_user_id">
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
                                        <th>Email ID</th>
                                        <th>Phone Number</th>
                                        <th>Engagement Type</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userData">
                                
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
                                    <center><button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next_button" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.storeList') }}" class="btn btn-secondary waves-effect cancel_button">
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