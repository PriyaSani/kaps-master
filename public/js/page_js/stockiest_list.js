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

$(document).on('click', '.stockiest_users', function(){
    var id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        url: "/stockiest/stockiest-users",
        data: {
            'id': id
        },
        success: function(data) {
           $('#modalcontent').html(data);
        }
    });

});

$(document).on('click', '.remove_stockiest_user', function(){
    var id = $(this).data('id');
    var stockiest_id = $(this).data('value');

    $.ajax({
        type: 'post',
        url: "/stockiest/remove-stockiest-users",
        data: {
            'id': id,
            'stockiest_id' : stockiest_id
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