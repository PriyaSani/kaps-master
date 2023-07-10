@extends('layouts.admin')
@section('title','Monthly Doctor History')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Monthly Doctor History</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monthly Doctor History</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
        
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Sales Month</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>   
                                @forelse($monthly as $mk => $mv) 
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ date('F Y',strtotime($mv['month'])) }}</td>
                                    <td> {{ $mv['sales']}} </td>
                                    <td>
                                        @php 
                                            $month = date('m',strtotime($mv['month']));
                                            $year = date('Y',strtotime($mv['month']));
                                        @endphp
                                        <a class="btn btn-primary waves-effect waves-light save_and_next_button" href="{{ route('admin.doctorMedicalstoreWiseSales',[$doctor_id,$id,$month,$year]) }}" role="button" title="Manage Profile"><i class="bx bx-store"></i></a>
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
<!-- Statement -->

@endsection
@section('js')
<script>
//sales amount script

</script>
@endsection