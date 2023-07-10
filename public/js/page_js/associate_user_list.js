$(document).on('change', '.custom-control-input', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/mr/mr-change-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            console.log(data);
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Mr Successfully Activated');    
                }else if(option == 0){
                    toastr.success('Mr Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('Mr Status Successfully Change!');
            }
        }
    });
});

$(document).on('click', '.user_details', function(){
    var id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        url: "/associated-user/edit-associated-user",
        data: {
            'id': id
        },
        success: function(data) {
           $('#modalcontent').html(data);
            
        }
    });

});

$(document).on('click', '.agency_details', function(){
    var id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        url: "/associated-user/associated-user-agency",
        data: {
            'id': id
        },
        success: function(data) {
           $('#modalcontent1').html(data);
        }
    });

});

$(document).on('click', '.remove_associated_user', function(){
    var id = $(this).data('id');
    var value = $(this).data('value');
    var type = $(this).data('type');

    $.ajax({
        type: 'post',
        url: "/associated-user/remove-associated-user",
        data: {
            'value': id,
            'id' : value,
            'type' : type
        },
        success: function(data) {
            if(data == 'true'){
                location.reload();
                toastr.success('User Successfully Deleted');   
            }else{
                toastr.success('Something Went Wrong!');   
            }
        }
    });

});