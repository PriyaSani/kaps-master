$(document).on('change', '.confirm_status', function(){
    
    var id = $(this).data('id');
    var staus = $(this).val();

    $.ajax({
        url: "/sales-history/confirm-status",
        method:'POST',
        data:{ staus:$(this).val(),id: $(this).data('id'),confirm_id : $(this).data('confirm'),sales_month : $(this).data('sales'),mr_id : $(this).data('mr')},
        success: function(data){
            if(data == 'true'){
                toastr.success('Conformation Status Successfully Change');    
                //get name of user
                if(staus == 0){
                    $('.confirm_name_'+id).html('-----');
                    $('.status_'+id).html('Pending');
                }else{
                    var name = $('.confirm_name_'+id).data('name');
                    $('.confirm_name_'+id).html(name);                    
                }
            }else{
                toastr.success('Something Went Wrong');
            }
        }
    });
});

$(document).on('keypress','.mr_suggestion',function(){
    // var added_user_id = $('.added_user_id').val();
    $.ajax({
        url: "/get-mr",
        type: "POST",
        data:{ name: $(this).val()},
        success: function(data){
            autocompletedatalist = data;
            $('.mr_suggestion').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    //event.preventDefault();
                    $('.mr_suggestion').val(ui.item.label);
                    $('.mr_id').val(ui.item.value);
                    
                    return false;
                }
            });
        }
    });
});