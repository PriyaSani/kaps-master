<div class="container-fluid ">
    <h5>Stockiest Name : {{$get_stockiest_detail->stockiest_name}}</h5>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation"  method="post">
                @csrf
                @if(!$get_stockiest_detail['stockiest_user']->isEmpty())
                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Name</th>
                            <th>Email ID</th>
                            <th>Phone Number</th>
                            <th>Engagement Type</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                            <tbody>
                                @foreach($get_stockiest_detail['stockiest_user'] as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv['stockiest_user_detail']['name'] }}  </td>
                                        <td>{{ $gv['stockiest_user_detail']['mobile'] }} </td>
                                        <td>{{ $gv['stockiest_user_detail']['email'] }} </td>
                                        @if($gv['engagement_type'] == 1)
                                            <td> Primary </td>
                                        @else
                                            <td> Secondary </td>
                                        @endif

                                        @if($gv['role'] == 1)
                                            <td> Owner </td>
                                        @else
                                            <td> Employee </td>
                                        @endif
                                        <td>
                                            <a class="btn btn-danger waves-effect waves-light remove_stockiest_user remove" data-id="{{$gv['stockiest_user_detail']['id']}}" data-value="{{$get_stockiest_detail->id}}" role="button" onclick="return confirm('Do you want to unlink this user?');"><i class="bx bx-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                @else
                    <h5>Associated User Not Found</h5>
                @endif
            </form>
        </div>
    </div>
</div>
