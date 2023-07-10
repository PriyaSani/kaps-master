@section('title', 'Book Service Request List')
@extends('layouts.admin')
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn"></div>
                        <h4 class="panel-title">Filter</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="{{route('admin.bookServiceRequest')}}" enctype="multipart/form-data" id="log">
                            @csrf
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <select class="form-control" name="city" id="city">
                                        <option value="">Select City</option>
                                        @if(count($cityList) > 0)
                                            @foreach($cityList as $ck => $cv)
                                                <option value="{{ $cv->id }}" @if($cv->id == $city) selected="selected" @endif>{{ $cv->city_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select class="form-control" name="service" id="service">
                                        <option value="">Select Service</option>
                                        @if(count($serviceList) > 0)
                                            @foreach($serviceList as $sk => $sv)
                                                <option value="{{ $sv->name }}" @if($sv->name == $service) selected="selected" @endif>{{ $sv->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control start" name="start" data-date-format="dd-mm-yyyy" placeholder="Date Start" autocomplete="off" @if(!empty($start_date)) value="{{$start_date}}" @endif>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control end" data-date-format="dd-mm-yyyy" name="end" placeholder="Date End" autocomplete="off" @if(!empty($end_date)) value="{{$end_date}}" @endif>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-sm btn-success float-right">Submit</button>
                                </div>
                                @if($filter == 1)
                                    <div class="col-md-1">
                                        <a  href="{{ route('admin.bookServiceRequest') }}"class="btn btn-sm btn-danger reset">Reset</a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <!-- begin row -->
      <div class="row">
          <!-- begin col-12 -->
          <div class="col-md-12">
              <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Book Service Request List</h4>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('admin.exportBookService')}}" method="post" id="csv_form">
                                @csrf
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary mb-3" id="create_csv" name="save_and_list" value="save_and_list" style="float:right;">Create CSV</a><br/><br/>

                                <input type="hidden" name="log_id" value="{{ json_encode($id_json) }}">
                            </form><br>
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>City</th>
                                            <th>Service</th>
                                            <th>Requested On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($serviceRequest as $sk => $sv)
                                        <tr class="odd gradeX">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$sv->name}}</td>
                                            <td>{{$sv->mobile}}</td>
                                            @if(isset($sv['city']) && !is_null($sv['city']))
                                                <td>{{$sv['city']['city_name']}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if(!is_null($sv->bookedservice) && count($sv->bookedservice) > 0)
                                                @php $service = array(); @endphp
                                                @foreach($sv->bookedservice as $bk => $bv)
                                                    @php $service[] = $bv->service->name; @endphp
                                                @endforeach
                                                <td>{{ implode(', ',$service) }}</td>
                                            @else
                                                <td>{{ $sv->service }}</td>
                                            @endif
                                            <td>{{ date('d-m-y h:i A',strtotime($sv->created_at)) }}</td>
                                            <td>
                                                
                                                <a href="{{route('admin.bookServiceRequestDetail',$sv->id)}}" type="button" class="btn btn-sm btn-success" value="Service Request Detail"> Service Request Detail</a>

                                                <a href="{{route('admin.adminFollowUp',$sv->id)}}" type="button" class="btn btn-sm btn-inverse" value="Follow Up"> Follow Up</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
    </div>
    <!-- end #content -->

@stop
@section('js')
<script>
    $(document).on('click','#create_csv',function(){
        $('#csv_form').submit();    
    });

    $('.input-daterange').datepicker({
        format: 'dd-mm-yyyy',
        endDate: new Date(),
    });
</script>
@endsection


