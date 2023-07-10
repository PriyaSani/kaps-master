@extends('layouts.admin')
@section('title','Add Territory')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Territory</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.territoryList') }}">Territory List</a></li>
                            <li class="breadcrumb-item active">Add Territory</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <!-- end row -->
            <div class="row">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <b class="mendatory_tag"><span class="mandatory">*</span> Mandatory Fields</b><br><br>    
                            <form class="custom-validation" action="{{ route('admin.saveTerritory') }}" method="post" id="territoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Territory Name<span class="mandatory">*</span></label>
                                <input type="text" class="form-control territory_name" name="territory_id" placeholder="Territory Name" autocomplete="off" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">State<span class="mandatory">*</span></label>
                                <select class="form-control select2 state_name" name="state_id">
                                    <option value="">Select State</option>
                                    @forelse ($get_state as $gk => $gv)
                                        <option value="{{$gv->id}}">{{$gv->state}}</option>
                                    @empty
                                        <option value="">Select State</option>
                                    @endforelse
                                </select>
                                <span id="state_id" class="state_id"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                    Save
                                </button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next_button" name="btn_submit" value="save_and_update">
                                    Save & Add New
                                </button>
                                <a href="{{ route('admin.territoryList') }}" class="btn btn-secondary waves-effect cancel_button">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
