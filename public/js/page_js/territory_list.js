$(document).on('change','.custom-control-input',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/territory/change-territory-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data == 'true'){
                if(option == 1){
                    toastr.success('Territory Successfully Activated');    
                }else if(option == 0){
                    toastr.success('Territory Successfully Deactivated');    
                }else{
                    toastr.success('Something Went Wrong');    
                }
            }else{
                toastr.success('Territory Status Successfully Change');
            }
        }
    });
})
$(document).on('click','.linked_person',function(){
    $.ajax({
        url: "/territory/linked-person-detail",
        type: "POST",
        data:{ 
            id: $(this).data('id'),
        },
        success: function(data){
            $('#modalcontent').html(data);
            $('#myModal').modal('show');
        }
    });
});