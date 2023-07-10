
    <h5>User Name : {{$get_user_detail->name}}</h5>
    <div class="container-fluid">
        <form method="post" action="{{ route('saveUserContact') }}" id="saveUserContact">
            @csrf

            <div class="form-group">
                <label for="modal_name">Name <span class="mandatory">*</span></label>
                <input type="text" class="form-control character" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" id="modal_name" name="name" value="{{$get_user_detail->name}}" placeholder="Name" required>
                <input type="hidden" value="{{$get_user_detail->id}}" class="added_user_id" name="id" id="id">
            </div>

            <div class="form-group">
                <label for="modal_email">Email</label>
                <input type="email" class="form-control" id="modal_email" name="email" placeholder="Email" value="{{$get_user_detail->email}}">
            </div>

            <div class="form-group">
                <label for="modal_mobile">Mobile <span class="mandatory">*</span></label>
                <input type="text" class="form-control numeric" id="modal_mobile" maxlength="10" minlength="10" name="mobile" placeholder="Mobile" value="{{$get_user_detail->mobile}}" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" name="save_and_list" value="save_and_list">Update</button>
            </div>
        </form>
    </div>

<script>

$.validator.addMethod("customemail", 
    function(value, element) {
        if(value == ""){
            return true;
        }else{
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);    
        }
    }, 
    "Please Enter Email ID Along with Domain Name."
);

$("#saveUserContact").validate({
    errorElement: 'span',
    rules: {
        name: {
            required: true,
        },
        email: {
            email: true,
            customemail : true,
            remote:{
                url: "/check-email-id",
                type: "post",
                data:{
                    id : function() {
                        return $('#id').val()
                    },
                },
            }
        },
        mobile: {
            required: true,
            minlength:10,
            maxlength:10,
            remote:{
                url: "/check-contact-number",
                type: "post",
                data:{
                    id : function() {
                        return $('#id').val()
                    },
                },
            }
        },
    },
    messages: {
        name:{
            required:"Please Enter Name",
        },
        email:{
            email:"Please Enter Valid Email Address",
            remote:"Email ID Already Exists!",
        },
        mobile:{
            required:"Please Enter Mobile",
            remote:"Mobile Already Exists!",
            minlength:"Please Enter 10 Digit Mobile",
            maxlength:"Please Enter 10 Digit Mobile",
        }
    }
});

$(document).on('submit','#saveUserContact',function(e){
    e.preventDefault();
    var added_user_id = $('.added_user_id').val();
    
    $.ajax({
        url: "{{ route('admin.saveEditedAssociatedUser') }}",
        type: "POST",
        data:{
            name : $('#modal_name').val(),
            email : $('#modal_email').val(),
            mobile : $('#modal_mobile').val(),
            id:added_user_id
        },
        success: function(data){
            if(data == 'true'){
                window.setTimeout(function(){location.reload()},1000)
                toastr.success('User Successfully Updated');   
            }else{
                toastr.success('Something Went Wrong!');   
            }
        }
    });

});
</script>