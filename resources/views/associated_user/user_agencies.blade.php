<div class="container-fluid ">
    <h5>User Name : {{$get_associated_users->name}}</h5>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation"  method="post">
                @csrf
                @if(!$get_associated_users['medical_store_user']->isEmpty())
                    <h5>Medical Store</h5>
                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Agency Name</th>
                            <th>Engagement Type</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                            <tbody>
                                @foreach($get_associated_users['medical_store_user'] as $gk => $gv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gv['store_detail']['store_name'] }}  </td>
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
                                            <a class="btn btn-danger waves-effect waves-light remove_associated_user remove" data-id="{{$gv['store_detail']['id']}}" title="Unlink User" data-value="{{$get_associated_users->id}}" data-type="1" role="button" onclick="return confirm('Do you want to unlink this user?');"><i class="bx bx-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                @endif
                @if(!$get_associated_users['stockiest_user']->isEmpty())
                    <h5>Stockiest</h5>
                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Agency Name</th>
                            <th>Engagement Type</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                            <tbody>
                                @foreach($get_associated_users['stockiest_user'] as $gk => $kv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kv['stockiest_detail']['stockiest_name'] }}  </td>
                                        @if($kv['engagement_type'] == 1)
                                            <td> Primary </td>
                                        @else
                                            <td> Secondary </td>
                                        @endif

                                        @if($kv['role'] == 1)
                                            <td> Owner </td>
                                        @else
                                            <td> Employee </td>
                                        @endif
                                        <td>
                                            <a class="btn btn-danger waves-effect waves-light remove_associated_user remove" data-id="{{$kv['stockiest_detail']['id']}}" title="Unlink User" data-value="{{$get_associated_users->id}}" data-type="2" role="button" onclick="return confirm('Do you want to unlink this user?');"><i class="bx bx-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                @endif
            </form>
        </div>
    </div>
</div>
