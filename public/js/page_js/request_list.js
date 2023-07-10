$(document).on('keypress','.doctor_suggestion',function(){
    // var added_user_id = $('.added_user_id').val();
    $.ajax({
        url: "/get-doctor",
        type: "POST",
        data:{ name: $(this).val()},
        success: function(data){
            autocompletedatalist = data;
            $('.doctor_suggestion').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    //event.preventDefault();
                    $('.doctor_suggestion').val(ui.item.label);
                    $('.doctor_id').val(ui.item.value);
                    
                    return false;
                }
            });
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

$(document).on('keypress','.territorry',function(){
    // var added_user_id = $('.added_user_id').val();
    $.ajax({
        url: "/get-territory",
        type: "POST",
        data:{ name: $(this).val()},
        success: function(data){
            autocompletedatalist = data;
            $('.territorry').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    //event.preventDefault();
                    $('.territorry').val(ui.item.label);
                    $('.main_territory').val(ui.item.value);

                    $.ajax({
                        url: "/get-dependent-sub-territories",
                        type: "POST",
                        data:{ 
                            territorry_id: ui.item.value
                        },
                        success: function(data){
                           $('.sub_territory').html(data);
                        }
                    });

                    return false;
                }
            });
        }
    });
});

$(document).on('change', '.payment_genrated', function(){
    
    var date = $(this).data('date');
    var id = $(this).data('id');
    var payment_genrated = $(this).val();

    $.ajax({
        url: "/all-request/update-payment-genrated",
        method:'POST',
        data:{ id: $(this).data('id'),payment_genrated: $(this).val()},
        success: function(data){
            if(data == 'true'){
                toastr.success('Status Successfully Change');  
                if(payment_genrated == 0){
                    $('.payment_date_'+id).html('-----');  
                    $('.receive_mr_date_'+id).html('-----');  
                    $('.paid_doctor_date_'+id).html('-----'); 
                    $('.received_by_mr_'+id).val(0).change();
                    $('.paid_to_doctor_'+id).val(0).change();
                }else{
                    $('.payment_date_'+id).html(date);      
                }
                
            }else{
                toastr.success('Something Went Wrong');
            }
        }
    });
});

$(document).on('change', '.received_by_mr', function(){
    
    var date = $(this).data('date');
    var id = $(this).data('id');
    var received_by_mr = $(this).val();

    $.ajax({
        url: "/all-request/update-received-mr",
        method:'POST',
        data:{ id: $(this).data('id'),received_by_mr : $(this).val()},
        success: function(data){
            if(data == 'true'){
                toastr.success('Status Successfully Change');    
                if(received_by_mr == 0){
                    $('.receive_mr_date_'+id).html('-----');  
                    $('.paid_doctor_date_'+id).html('-----');  
                    $('.paid_to_doctor_'+id).val(0).change();
                }else{
                    $('.receive_mr_date_'+id).html(date);  
                }
            }else{
                toastr.success('Something Went Wrong');
            }
        }
    });
});

$(document).on('change', '.paid_to_doctor', function(){
    
    var date = $(this).data('date');
    var id = $(this).data('id');
    var paid_to_doctor = $(this).val();

    $.ajax({
        url: "/all-request/update-paid-doctor",
        method:'POST',
        data:{ id: $(this).data('id'),paid_to_doctor : $(this).val()},
        success: function(data){
            if(data == 'true'){
                if(paid_to_doctor == 0){
                    $('.paid_doctor_date_'+id).html('-----');   
                }else{
                    $('.payment_genrated_'+id).val(1).change();
                    $('.received_by_mr_'+id).val(1).change();
                    $('.paid_doctor_date_'+id).html(date);   
                    $('.receive_mr_date_'+id).html(date);  
                    $('.payment_date_'+id).html(date);    
                }
                
                toastr.success('Status Successfully Change');   
            }else{
                toastr.success('Something Went Wrong');
            }
        }
    });
});