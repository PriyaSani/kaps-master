@extends('layouts.admin')
@section('title','MR List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">MR List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">MR List</li>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Territories</th>
                                    <th>Sub Territories</th>
                                    <th>DOB</th>
                                    <th>Joining Date</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($get_mr))
                                    @foreach($get_mr as $gk => $gv)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $gv->full_name }}</td>
                                            <td>{{ $gv->email }}</td>
                                            <td>{{ $gv->mobile_number }}</td>
                                            <td>{{ $gv->address }}</td>

                                            @if(!is_null($gv['get_territory']))
                                            @php $stops = array(); @endphp
                                            @php $unique_stops = array(); @endphp
                                                @foreach($gv['get_territory'] as $sk => $sv)
                                                    @if(!empty($sv['territory_name']))
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

                                            @if(!is_null($gv['get_territory']))
                                                @php 
                                                    $subTerritory = array(); 
                                                    $unique_stops = array(); 
                                                @endphp
                                                @foreach($gv['get_territory'] as $sk => $sv)
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

                                            <td>{{ $gv->dob ? date('d/m/Y',strtotime($gv->dob)) : '----------'}}</td>
                                            <td>{{ $gv->joining_date ? date('d/m/Y',strtotime($gv->joining_date)) : '---------'}}</td>
                                            <td>{{ $gv->remarks }}</td>
                                            @php $checked = ''; @endphp
                                            @if($gv->is_active == 1) @php $checked = 'checked' @endphp @endif
                                            <td>
                                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{$gk}}" value="1" data-id="{{ $gv->id }}" {{ $checked }}>
                                                    <label class="custom-control-label toastr" for="customSwitch{{$gk}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.editMr',$gv->id) }}" role="button" title="Edit MR"><i class="bx bx-pencil"></i></a>
                                                <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteMr',$gv->id) }}" role="button" title="Remove MR" onclick="return confirm('Do you want to delete this mr?');"><i class="bx bx-trash-alt"></i></a>
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
@endsection
@section('js')
<script>

</script>
@endsection