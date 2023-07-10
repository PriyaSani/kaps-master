@extends('layouts.admin')
@section('title','Edit Sub Territory')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Sub Territory</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.subTerritoryList',$territory_id) }}">Sub Territory List</a></li>
                            <li class="breadcrumb-item active">Edit Sub Territory</li>
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
                            <form class="custom-validation" action="{{ route('admin.updateSubTerritory') }}" method="post" id="subTerritoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Sub Territory Name<span class="mandatory">*</span></label>
                                <input type="text" class="form-control sub_territory" name="sub_territory" placeholder="Sub Territory Name" autocomplete="off" value="{{$get_sub_territory->sub_territory}}" required/>
                                <input type="hidden" name="territory_id" value="{{$territory_id}}">
                                <input type="hidden" name="id" class="id" value="{{$get_sub_territory->id}}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                    Update
                                </button>
                                <a href="{{ route('admin.subTerritoryList',$territory_id) }}" class="btn btn-secondary waves-effect cancel_button">
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
