<div class="container-fluid ">
    <b>Doctor Name : {{$doctor_details->full_name}}</b>
    <br><br>
    <div class="row ">
        <div class="col-md-12">
            @if(isset($get_profile_detail->id) && ($get_profile_detail->id != '')) 
            <form class="custom-validation" action="{{ route('admin.updateDoctorProfile') }}" method="post" id="updateDoctorProfile" enctype="multipart/form-data">
            @else
            <form class="custom-validation" action="{{ route('admin.saveDoctorProfile') }}" method="post" id="saveDoctorProfile" enctype="multipart/form-data">
            @endif
                @csrf
                <div class="form-group">
                    <label>Profile Name<span class="mandatory">*</span></label>
                    <input type="text" class="form-control" name="profile_name" placeholder="Profile Name" autocomplete="off"  required @if(isset($get_profile_detail->profile_name) && ($get_profile_detail->profile_name != '')) value="{{$get_profile_detail->profile_name}}" @endif />
                </div>
                
                @if(isset($get_profile_detail->id) && ($get_profile_detail->id != '')) 
                    <input type="hidden" name="id" id="id" value="{{$get_profile_detail->id}}">
                @endif
                
                <input type="hidden" name="doctor_id" value="{{$doctor_details->id}}">

                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 save_button" name="btn_submit" value="save">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$("#updateDoctorProfile").validate({
    errorElement: 'span',
    rules: {
        profile_name: {
            required: true,
            remote:{
                url: "/doctor/check-doctor-profile",
                type: "post",
                data:{
                    id : function() {
                        return $('#id').val()
                    },
                }
            }
        }
        
    },
    messages: {
        profile_name: {
            required: 'Enter Profile Name',
            remote: 'Profile Already Exists'
        }
    }
});
</script>




