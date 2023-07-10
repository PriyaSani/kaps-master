<div class="container-fluid ">
    <h5></h5>
     <form class="custom-validation" action="{{ route('admin.stockiestAttachment') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title mb-4 float-right"><span class="mandatory">*</span> Mendatory</h4> -->
                        <h4 class="card-title mb-4">{{$get_statement['stockiest_detail']['stockiest_name']}}</h4>
                        <div class="row">	
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formrow-email-input">Month</label>
                                    <input type="text" class="form-control" id="formrow-text-input" value="{{ date('F',strtotime($get_statement->sales_month)) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formrow-password-input">Year</label>
                                    <input type="text" class="form-control" id="formrow-text-input" disabled="disabled" value="{{ date('Y',strtotime($get_statement->sales_month)) }}">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="mr_id" value="{{$get_statement->mr_id}}">
                        <input type="hidden" name="id" value="{{$get_statement->id}}">
                        <input type="hidden" name="sales_id" value="{{$get_statement->sales_id}}">
                        <h4 class="card-title mb-4">MR Details</h4>
                        <div class="inner-repeater mb-4">
                            <div data-repeater-list="inner-group" class="inner form-group mb-0 row">
			                    <div  data-repeater-item class="inner col-lg-12 ml-md-auto">
			                    	<div class="mb-3 row align-items-center">
			                    		<div class="col-md-8">
                                            <div class="mt-4 mt-md-0">
                                                <input type="file" name="statement[]" class="form-control-file upload_file" multiple="multiple">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mt-2 mt-md-0">
                                                <a class="btn btn-danger waves-effect waves-light remove_file remove" href="javascript:void(0);" role="button" title="Remove Statement" onclick="return confirm('Do you want to remove this statement?');"><i class="bx bx-trash-alt"></i></a>
                                            </div>
                                        </div>
			                    	</div>
			                    </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary save_button">Submit</button>
                            </div>
                            <div class="col-lg-10">
                                
                            </div>
                        </div>
		                @if(!$get_attachment->isEmpty())
                        <br><br><hr>
		                    <h5>Uploaded Statement</h5>
                            <hr>
                            <h5 class="float-right">Download All <a href="{{route('admin.downloadStatementZip',$get_statement->id)}}" class="btn btn-primary waves-effect waves-light " title="Download All" role="button"><i class="bx bx-download"></i></a></h5>
		                    <table id="" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
		                        <thead>
		                        <tr>
		                            <th>Sr.no</th>
		                            <th>Statement</th>
		                            <th>Action</th>
		                        </tr>
		                        </thead>
		                            <tbody>
		                                @foreach($get_attachment as $ak => $av)
		                                    <tr class="statement remove_statement_{{$av->id}}">
		                                        <td>{{ $loop->iteration }}</td>
		                                        <td>{{ $av->statement }}</td>
		                                        <td>

													<a href="{{ asset('uploads/statement') }}/{{$av->statement}}" class="btn btn-primary waves-effect waves-light" title="Download Statement" download="download" role="button"><i class="bx bx-download"></i></a>		                                        	
													<a href="{{ asset('uploads/statement') }}/{{$av->statement}}" target="_blank" class="btn btn-primary waves-effect waves-light" title="View Statement"  role="button"><i class="bx bx-show-alt"></i></a>		                             

		                                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light remove_attachment remove" data-id="{{$av->id}}" title="Remove Statement" role="button" onclick="return confirm('Do you want to remove this statement?');"><i class="bx bx-trash-alt"></i></a>

		                                        </td>
		                                    </tr>
		                                @endforeach
		                            </tbody>
		                    </table>
		                @endif                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
$(document).on('click','.remove_file',function(){
	$('.upload_file').val('');
});

$(document).on('click','.remove_attachment',function(){
	var id = $(this).data('id');
	$.ajax({
        url: "/sales-history/remove-statement",
        type: "POST",
        data:{ 
            'id' : id
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Statement Successfully Remove');
                $('.remove_statement_'+id).hide();
            }else{
                toastr.error('Something Wrong');
            }
        }
    });
});
</script>
