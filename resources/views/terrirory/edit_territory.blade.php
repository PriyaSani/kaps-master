@extends('layouts.admin')
@section('title','Edit Territory')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Territory</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.territoryList') }}">Territory List</a></li>
                            <li class="breadcrumb-item active">Edit Territory</li>
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
                            <form class="custom-validation" action="{{ route('admin.updateTerritory') }}" method="post" id="territoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Territory Name<span class="mandatory">*</span></label>
                                <input type="text" class="form-control territory_name" name="territory_id" placeholder="Territory Name" autocomplete="off" value="{{$get_territory_detail->territory_id}}" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">State<span class="mandatory">*</span></label>
                                <select class="form-control select2 state_name" name="state_id">
                                    <option value="">Select State</option>
                                    @forelse ($get_state as $gk => $gv)
                                        <option value="{{$gv->id}}" @if($get_territory_detail->state_id == $gv->id) selected="selected" @endif>{{$gv->state}}</option>
                                    @empty
                                        <option value="">Select State</option>
                                    @endforelse
                                </select>
                                <input type="hidden" name="id" class="id" value="{{$get_territory_detail->id}}">
                                <span id="state_id" class="state_id"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                    Update
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
