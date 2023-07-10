@extends('layouts.admin')
@section('title','SubTerritory List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Sub Territory List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sub Territory List</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form>
                    <h4 class="mb-0 font-size-18" style="float:left;margin-top: 5px;margin-left: 2%;">{{$get_territory->territory_id}} , {{ucwords(strtolower($get_territory['get_state']['state']))}}</h4>
                    <a href="{{ route('admin.addSubTerritory',$id) }}" class="btn btn-primary mb-3 save_and_next_button" style="float:right;margin-right: 10px;margin-top: 5px;">Add Sub Territory</a><br/><br/>
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Sub Territory</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($get_sub_territory as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->sub_territory }}</td>
                                        @php $checked = ''; @endphp
                                        @if($gv->is_active == 1) @php $checked = 'checked' @endphp @endif
                                        <td>
                                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$gk}}" value="1" data-id="{{ $gv->id }}" {{ $checked }}>
                                                <label class="custom-control-label toastr" for="customSwitch{{$gk}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.editSubTerritory',['id' => $gv->id, 'territory_id' => $id]) }}" title="Edit Sub Territory" role="button"><i class="bx bx-pencil"></i></a>
                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteSubTerritory',['id' => $gv->id, 'territory_id' => $id]) }}" title="Delete Sub Territory" role="button" onclick="return confirm('Do you want to delete this sub territory?');"><i class="bx bx-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection
@section('js')
<script>

</script>
@endsection