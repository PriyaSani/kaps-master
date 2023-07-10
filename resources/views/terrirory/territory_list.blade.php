@extends('layouts.admin')
@section('title','Territory List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Territory List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Territory List</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Territory Name</th>
                                    <th>State</th>
                                    <th>Linked Persons</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($get_territory as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->territory_id }}</td>
                                        <td>{{ $gv->get_state->state }}</td>
                                        <?php
                                        $sub_territory = \App\Model\SubTerritory::where('territory_id',$gv->id)->pluck('id')->toArray();
                                            if(!empty($sub_territory)){

                                                $id = $gv->id;
                                                $get_mr = \App\Model\MrDetail::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->count();

                                                $get_doctor = \App\Model\DoctorDetail::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->count();

                                                $get_employee = \App\Model\User::whereHas('get_territory', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('get_territory', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->count();

                                                $get_stockiest = \App\Model\Stockiest::whereHas('stockiest_territories', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('stockiest_territories', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->count();
        
                                                $get_medical_store = \App\Model\MedicalStore::whereHas('mendical_store_territories', function ($query) use ($id) { $query->where('territories_id', $id); })->WhereHas('mendical_store_territories', function ($query) use ($sub_territory) { $query->whereIn('sub_territories',$sub_territory); })->where('is_delete',0)->count();

                                                $total = $get_mr + $get_doctor + $get_employee + $get_stockiest + $get_medical_store;
                                                
                                            }else{

                                                $total = 0;
                                                
                                            }
                                        ?>
                                        <td><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="linked_person" data-id="{{$gv->id}}"><span class="number_css">@if(isset($total)){{ $total }} @else {{ 0 }} @endif</span></a></td>
                                         @php $checked = ''; @endphp
                                        @if($gv->is_active == 1) @php $checked = 'checked' @endphp @endif
                                        <td>
                                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$gk}}" value="1" data-id="{{ $gv->id }}" {{ $checked }}>
                                                <label class="custom-control-label toastr" for="customSwitch{{$gk}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.subTerritoryList',$gv->id) }}" role="button" title="Add Sub Territory"><i class="bx bx-plus"></i></a>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.editTerritory',$gv->id) }}" role="button" title="Edit Territory"><i class="bx bx-pencil"></i></a>
                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteTerritory',$gv->id) }}" title="Remove Territory cancel_button" role="button" onclick="return confirm('Do you want to delete this territory?');"><i class="bx bx-trash-alt"></i></a>
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
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Linked Person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  id="modalcontent">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect cancel_button" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('js')
<script>

</script>
@endsection