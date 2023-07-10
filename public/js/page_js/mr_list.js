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
                    toastr.success('MR Successfully Activated');    
                }else if(option == 0){
                    toastr.success('MR Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong!');    
                }
            }else{
                toastr.success('MR Status Successfully Change!');
            }
        }
    });
});