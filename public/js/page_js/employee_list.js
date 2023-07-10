$(document).on('change', '.custom-control-input', function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    var id = $(this).data('id');
    $.ajax({
        url: "/employee/employee-change-status",
        method:'POST',
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            console.log(data);
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Employee Successfully Activated');    
                }else if(option == 0){
                    toastr.success('Employee Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('Employee Status Successfully Change!');
            }
        }
    });
});