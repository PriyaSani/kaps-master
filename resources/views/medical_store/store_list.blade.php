@extends('layouts.admin')
@section('title','Medical Store List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Medical Store List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Medical Store List</li>
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
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Store Name</th>
                                    <th>Address</th>
                                    <th>Store Phone Number</th>
                                    <th>Store Email ID</th>
                                    <th>GST No</th>
                                    <th>Territories</th>
                                    <th>Sub Territories</th>
                                    <th>Linked Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_store))
                                @foreach($get_store as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv->store_name }}</td>
                                        <td>{{ $gv->store_address }}</td>
                                        <td>{{ $gv->store_phone_number }}</td>
                                        <td>{{ $gv->store_email_id }}</td>
                                        <td>{{ $gv->gst_number }}</td>
                                        
                                        @if(!is_null($gv['mendical_store_territories']))
                                        @php $stops = array(); @endphp
                                        @php $unique_stops = array(); @endphp
                                            @foreach($gv['mendical_store_territories'] as $sk => $sv)
                                                @if(!empty($sv['territory_name']['territory_id']))
                                                    @if(!in_array($sv['territory_name']['territory_id'],$unique_stops))
                                                        @php $unique_stops[] =  $sv['territory_name']['territory_id']; @endphp
                                                       @php $stops[] = $sv['territory_name']['territory_id']; @endphp 
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td>{{ rtrim(implode(' | ',$stops), " | ") }}</td>
                                        @else
                                            <td> -------- </td>
                                        @endif

                                        @if(!is_null($gv['mendical_store_territories']))
                                            @php
                                                $subTerritory = array(); 
                                                $unique_stops = array(); 
                                            @endphp
                                            @foreach($gv['mendical_store_territories'] as $sk => $sv)
                                                @if(!empty($sv['sub_territory']))
                                                    @if(!in_array($sv['sub_territory']['sub_territory'],$unique_stops))
                                                        @php 
                                                            $unique_stops[] =  $sv['sub_territory']['sub_territory']; 
                                                        @endphp
                                                        @php 
                                                            $subTerritory[] = $sv['sub_territory']['sub_territory']; 
                                                        @endphp 
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td>{{ rtrim(implode(' | ',$subTerritory), " | ") }}</td>
                                        @else
                                            <td> -------- </td>
                                        @endif

                                        <td class="stockiest_users" data-id="{{$gv->id}}" data-toggle="modal" data-target="#example_02"><b style="cursor: pointer;" class="number_css">{{ count($gv['medical_store_user']) }}</b></td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.editStore',$gv->id) }}" title="Edit Medical Store" role="button"><i class="bx bx-pencil"></i></a>
                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteStore',$gv->id) }}" title="Remove Medical Store" role="button" onclick="return confirm('Do you want to delete this medical store?');"><i class="bx bx-trash-alt"></i></a>
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
<div class="modal fade"  id="example_02" tabindex="-1" role="dialog" aria-labelledby="example_02" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Associated Users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modalcontent">
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
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