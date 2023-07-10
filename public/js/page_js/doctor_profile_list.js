$(document).on('change', '.custom-control-input', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/doctor/doctor-change-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            console.log(data);
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Doctor Successfully Activated');    
                }else if(option == 0){
                    toastr.success('Doctor Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('Doctor Status Successfully Change!');
            }
        }
    });
});

$(document).on('click', '.update_profile', function(){
    
    var doctor_id = $(this).data('id');
    var id = $(this).data('value');

    if(id != ''){
        var sender_id = id;
    }
    $.ajax({
        url: "/doctor/edit-doctor-profile",
        method:'POST',
        data:{ doctor_id: doctor_id,sender_id : sender_id},
        success: function(data){
            $('#modalcontent').html(data);
        }
    });
});