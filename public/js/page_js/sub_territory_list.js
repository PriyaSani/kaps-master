$(document).on('change','.custom-control-input',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/territory/change-sub-territory-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Sub Territory Successfully Activated');    
                }else if(option == 0){
                    toastr.success('Sub Territory Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong');    
                }
            }else{
                toastr.success('Sub Territory Status Successfully Change');
            }
        }
    });
})