$(document).on('change', '.status', function(){

    var status = $(this).val();
    var id = $(this).data('id');
    
    console.log(status);
    $.ajax({
        url: "/doctor/update-request-payment-genrated",
        method:'POST',
        data:{ id: $(this).data('id'),status: $(this).val()},
        success: function(data){
            if(data == 'true'){
                if(status == 0 || status == 1){
                    $('.payment_date_'+id).html('-----');  
                    $('.receive_mr_date_'+id).html('-----');  
                    $('.paid_doctor_date_'+id).html('-----'); 
                    $('.option_'+id).hide();
                    $('.option_other_'+id).show();
                }else{

                    $('.option_'+id).show();
                    $('.option_other_'+id).hide();
                }
                
                toastr.success('Status Successfully Change');  
            }else{
                toastr.success('Something Went Wrong');
            }
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
        url: "/doctor/update-request-received-mr",
        method:'POST',
        data:{ id: $(this).data('id'),received_by_mr : $(this).val()},
        success: function(data){
            if(data == 'true'){
                if(received_by_mr == 0){
                    $('.receive_mr_date_'+id).html('-----');  
                    $('.paid_doctor_date_'+id).html('-----');  
                    $('.paid_to_doctor_'+id).val(0).change();
                }else{
                    $('.receive_mr_date_'+id).html(date);  
                }
                toastr.success('Status Successfully Change');    
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
        url: "/doctor/update-doctor-paid-doctor",
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