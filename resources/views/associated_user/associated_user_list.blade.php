@extends('layouts.admin')
@section('title','Associated User List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Associated User List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Associated User List</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>   

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.associatedUserList') }}" id="company">
                            @csrf
                            <div class="form-row">

                                <div class="col-md-4 mb-3">
                                    <label for="">Agency Link Type</label>
                                    <select class="form-control" name="agency_link_type">
                                        <option value="">Select Agency Link</option>
                                        <option value="1" @if($agency_link_type == 1) selected="selected" @endif>Medical Store</option>
                                        <option value="2" @if($agency_link_type == 2) selected="selected" @endif>Stockiest</option>
                                        <option value="3" @if($agency_link_type == 3) selected="selected" @endif>Both</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button">Submit</button>
                                </div>
                                @if($filter == 1)
                                    <div class="col-md-1 mt-4" style="margin-left: 2%;margin-top: 1.3rem!important">
                                        <a href="{{ route('admin.associatedUserList') }}" class="btn btn-danger mt-1 cancel_button " id="filter" name="save_and_list" value="save_and_list" style="margin-left: -100px;">Reset</a>
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
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Email ID</th>
                                    <th>Agency Type</th>
                                    <th>Linked Agencies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_associated_users))
                                @foreach($get_associated_users as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->name }}</td>
                                        <td>{{ $gv->mobile }}</td>
                                        <td>{{ $gv->email }}</td>
                                        @if($gv->medical_associate == 1 && $gv->stockiest_associate == 1)
                                            <td>Medical Store | Stockiest</td>
                                        @elseif($gv->medical_associate == 1)
                                            <td>Medical Store</td>
                                        @elseif($gv->stockiest_associate == 1)
                                            <td>Stockiest</td>
                                        @else
                                            <td>Not Associated</td>
                                        @endif
                                        @php 
                                            $medical_count = count($gv['medical_store_user']);
                                            $stokiest_count = count($gv['stockiest_user']);
                                            $total_linked_count = $medical_count + $stokiest_count;
                                        @endphp
                                        <td class="agency_details number_css" data-id="{{$gv->id}}" data-toggle="modal" data-target="#example_01"><b style="cursor: pointer;">{{ $total_linked_count }}</b></td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light user_details save_and_next_button" href="javascript:void(0);" data-toggle="modal" data-target="#example_02" data-id="{{$gv->id}}" role="button" title="Edit User"><i class="bx bx-pencil"></i></a>
                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteAssociatedUser',$gv->id) }}" role="button" title="Remove User" onclick="return confirm('Do you want to delete this users?');"><i class="bx bx-trash-alt"></i></a>
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
<!-- Modal -->
<div class="modal fade" id="example_02" tabindex="-1" role="dialog" aria-labelledby="example_02" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
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

<div class="modal fade"  id="example_01" tabindex="-1" role="dialog" aria-labelledby="example_01" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Associated Users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modalcontent1">
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary cancel_button" data-dismiss="modal">
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