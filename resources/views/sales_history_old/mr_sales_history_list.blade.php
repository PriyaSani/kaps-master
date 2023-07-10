@extends('layouts.admin')
@section('title','Sales History')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Sales History</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales History</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.salesHistoryList') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Select Month</label>
                                    <select class="form-control" name="month">
                                        <option value="">Select Month</option>
                                        @forelse($months as $mk => $mv)
                                            <option value="{{$mk + 1}}" @if($month == $mk+1) selected="selected" @endif >{{$mv}}</option>
                                        @empty
                                            <option value="">Month Data Not Found</option>
                                        @endforelse
                                        
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Select Year</label>
                                    <select class="form-control" name="year">
                                        <option value="">Select Year</option>
                                        @for($i=$first_year;$i<=$last_year;$i++)
                                            <option value="{{$i}}" @if($i == $year) selected="selected" @endif >{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Select MR</label>
                                    <input type="text" class="form-control mr_suggestion" id="inputMr" name="mr" placeholder="Mr Name" @if(isset($mr)) value="{{$mr}}" @endif autocomplete="off">
                                    <input type="hidden" name="mr_id" @if(isset($mr_id)) value="{{$mr_id}}" @endif class="mr_id">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Select Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Status</option>
                                        <option value="0" @if($status == 0 && $status != '') selected="selected" @endif >Pending</option>
                                        <option value="1" @if($status == 1) selected="selected" @endif >Confirm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors">Submit</button>
                                </div>
                            @if(isset($filter) && ($filter == 1))
                                <div class="col-md-1 mt-4" style="margin-left: 2%;margin-top: 1.3rem!important">
                                    <a href="{{ route('admin.salesHistoryList') }}" class="btn btn-danger mt-1" id="filter" name="save_and_list" value="save_and_list" style="margin-left: -100px;">Reset</a>
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
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>MR</th>
                                    <th>Sales Month</th>
                                    <th>Submitted On</th>
                                    <th>Status</th>
                                    <th>Conformation Status</th>
                                    <th>Confirm By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($get_sales_data))
                                @foreach($get_sales_data as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv['mr_detail']['full_name'] }}</td>
                                        <td>{{ date('F Y',strtotime($gv->sales_month)) }}</td>
                                        <td><center>{{ $gv->submitted_on != '' ? date('d/m/Y',strtotime($gv->submitted_on)) : '-----' }}</center></td>
                                        <td>{{ $gv->is_submited == 1 ? 'Submitted' : 'Pending' }}</td>
                                        @if($gv->is_submited == '1')
                                        <td>
                                            <select class="form-control confirm_status" data-id="{{$gv->id}}" data-confirm="{{ Auth::guard()->user()->id }}" data-sales="{{$gv->sales_month}}" data-mr="{{$gv->mr_id}}">
                                                <option @if(isset($gv->confirm_status) &&  ($gv->confirm_status == 0)) selected="selected" @endif value="0" >Pending</option>
                                                <option @if(isset($gv->confirm_status) &&  ($gv->confirm_status == 1)) selected="selected" @endif value="1" >Confirmed</option>
                                            </select>
                                        </td>
                                        @else
                                        <td><center> ----- </center></td>
                                        @endif
                                        <td class="confirm_name_{{$gv->id}}" data-name="{{Auth::guard()->user()->name}}">{{ $gv->confirm_by_id != '' ? $gv['user_detail']['name'] : '-----' }}</td>
                                        <td>
                                            <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.mrHistoryReportList',$gv->id) }}" role="button"><i class="bx bx-pencil"></i></a>
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