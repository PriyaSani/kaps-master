
<div class="row">
    <div class="col-xl-1">
    </div>
    <div class="col-xl-10">
        <div class="card">
            <div class="card-body">
                
                <!-- <h4 class="card-title mb-4">Task</h4> -->

                <ul class="nav nav-pills bg-light rounded" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active save_and_next_button" data-toggle="tab" href="#transactions-all-tab" role="tab">MRs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link save_and_next_button" data-toggle="tab" href="#transactions-buy-tab" role="tab">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link save_and_next_button" data-toggle="tab" href="#transactions-sell-tab" role="tab">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link save_and_next_button" data-toggle="tab" href="#transactions-buy-tab1" role="tab">Stockiest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link save_and_next_button" data-toggle="tab" href="#transactions-sell-tab1" role="tab">Medical Store</a>
                    </li>
                </ul>
                <div class="tab-content mt-4">
                    <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table table-centered table-nowrap">
                                <tbody>
                                    @forelse($get_mr as $mk => $mv)
                                    <tr>
                                        <td>
                                            <div>

                                                <h5 class="font-size-14 mb-1"><a href="javascript::void(0);" style="color: #495057;">{{$mv->full_name}}</a></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <center><h5 class="font-size-14 mb-1">Record not found!</h5></center>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table table-centered table-nowrap">
                                <tbody>
                                    @forelse($get_doctor as $dk => $dv)
                                    <tr>
                                        <td>
                                            <div>

                                                <h5 class="font-size-14 mb-1"><a href="javascript::void(0);" style="color: #495057;">{{$dv->full_name}}</a></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <center><h5 class="font-size-14 mb-1">Record not found!</h5></center>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="transactions-sell-tab" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table table-centered table-nowrap">
                                <tbody>
                                    @forelse($get_employee as $ek => $ev)
                                    <tr>
                                        <td>
                                            <div>

                                                <h5 class="font-size-14 mb-1"><a href="javascript::void(0);" style="color: #495057;">{{$ev->name}}</a></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <center><h5 class="font-size-14 mb-1">Record not found!</h5></center>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

                    <div class="tab-pane" id="transactions-buy-tab1" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table table-centered table-nowrap">
                                <tbody>
                                    @forelse($get_stockiest as $sk => $sv)
                                    <tr>
                                        <td>
                                            <div>

                                                <h5 class="font-size-14 mb-1"><a href="javascript::void(0);" style="color: #495057;">{{$sv->stockiest_name}}</a></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <center><h5 class="font-size-14 mb-1">Record not found!</h5></center>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

                    <div class="tab-pane" id="transactions-sell-tab1" role="tabpanel">
                        <div class="table-responsive" data-simplebar style="max-height: 330px;">
                            <table class="table table-centered table-nowrap">
                                <tbody>
                                    @forelse($get_medical_store as $mk => $mv)
                                    <tr>
                                        <td>
                                            <div>

                                                <h5 class="font-size-14 mb-1"><a href="javascript::void(0);" style="color: #495057;">{{$mv->store_name}}</a></h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <center><h5 class="font-size-14 mb-1">Record not found!</h5></center>
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    
                </div><br>
                <div class="text-center">
                    <!-- <button type="button" class="btn btn-primary w-md">View More</button> -->
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-1">
    </div>
</div>

