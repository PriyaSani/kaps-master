@extends('layouts.admin')
@section('title','Employee List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Employee List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee List</li>
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
                                    <th>Email ID</th>
                                    <th>Mobile Number</th>
                                    <th>Territories</th>
                                    <th>Sub Territories</th>
                                    <th>Address</th>
                                    <th>DOB</th>
                                    <th>Joining Date</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($getEmployee))
                                @foreach($getEmployee as $ek => $ev)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ev->name }}</td>
                                        <td>{{ $ev->email }}</td>
                                        <td>{{ $ev->mobile }}</td>
                                        
                                        @if(!is_null($ev['get_territory']))
                                        @php $stops = array(); @endphp
                                            @foreach($ev['get_territory'] as $sk => $sv)
                                                @if(isset($sv['territory_name']['territory_id']) && ($sv['territory_name']['territory_id'] != ''))
                                                   @php $stops[] = $sv['territory_name']['territory_id']; @endphp 
                                                @endif
                                            @endforeach
                                            <td>{{ implode(' | ',$stops) }}</td>
                                        @else
                                            <td> -------- </td>
                                        @endif

                                        @if(!is_null($ev['get_territory']))
                                            @php 
                                                $subTerritory = array(); 
                                                $unique_stops = array(); 
                                            @endphp
                                            @foreach($ev['get_territory'] as $sk => $sv)
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

                                        <td>{{ $ev->address }}</td>
                                        <td>{{ $ev->dob ? date('d/m/Y',strtotime($ev->dob)) : "--------" }}</td>
                                        <td>{{ $ev->joining_date ? date('d/m/Y',strtotime($ev->joining_date)) : "--------" }}</td>
                                        <td>{{ $ev->remarks }}</td>
                                        @php $checked = ''; @endphp
                                        @if($ev->is_active == 1) @php $checked = 'checked' @endphp @endif
                                        <td>
                                            <div class="custom-control custom-switch mb-2" dir="ltr">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$ek}}" value="1" data-id="{{ $ev->id }}" {{ $checked }}>
                                                <label class="custom-control-label toastr" for="customSwitch{{$ek}}"></label>
                                            </div>
                                           
                                        </td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.editEmployee',$ev->id) }}" title="Edit Employee" role="button"><i class="bx bx-pencil"></i></a>
                                            <a class="btn btn-danger waves-effect waves-light cancel_button" href="{{ route('admin.deleteEmployee',$ev->id) }}" title="Remove Employee" role="button" onclick="return confirm('Do you want to delete this employee?');"><i class="bx bx-trash-alt"></i></a>
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