@extends('layouts.admin')
@section('title','Add Sub Territory')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Sub Territory</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.subTerritoryList',$id) }}">Sub Territory List</a></li>
                            <li class="breadcrumb-item active">Add Sub Territory</li>
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
                            <form class="custom-validation" action="{{ route('admin.saveSubTerritory') }}" method="post" id="subTerritoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Sub Territory Name<span class="mandatory">*</span></label>
                                <input type="text" class="form-control sub_territory" name="sub_territory" placeholder="Sub Territory Name" autocomplete="off" required/>
                                <input type="hidden" name="id" class="territory_id" value="{{$id}}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                                        Save
                                </button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light mr-1 save_and_next_button" name="btn_submit" value="save_and_add">
                                    Save & Add New
                                </button>
                                <a href="{{ route('admin.subTerritoryList',$id) }}" class="btn btn-secondary waves-effect cancel_button">
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
