@extends('layouts.admin')
@section('title','Medical Store wise Doctor Sales')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Medical Store wise Doctor Sales</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Medical Store wise Doctor Sales</li>
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
                                    <th>Medical Store Name</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>   
                                @forelse($sales_data as $sk => $sv) 
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $sv['store_detail']['store_detail']['store_name'] }}</td>
                                    <td>{{ $sv['sales_amount']}} </td>
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