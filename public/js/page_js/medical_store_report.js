//sales amount script
$(document).on('click','.sales_amount',function(){
    var id = $(this).data('id');
    $('.sales_button_'+id).show();
});   

$(document).on('click','.add_sales_amount',function(){

    var id = $(this).data('id');
    var amount = $('.amount_sales_'+id).val();
    var store_id = $(this).data('store');

    $.ajax({
        url: "/sales-history/save-medical-store-amount",
        type: "POST",
        data:{ 
            'amount' : amount,
            'type' : 1,
            'id' : id,
            'store_id' : store_id,
            'date' : $('#currentMonthDate').val()
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Amount Successfully Change');
                $('.sales_button_'+id).hide();
            }else{
                toastr.error('Amount exceeded total sales');
            }
        }
    });

});

$(document).on('click','.remove_sales_amount',function(){
    var id = $(this).data('id');
    $('.sales_button_'+id).hide();
    var get_value = $('.amount_sales_'+id).val();
    console.log(get_value); 
    var value = $('.amount_sales_'+id).data('value');
    console.log(value); 
    $('.amount_sales_'+id).val(value);
});  
//end

//extra business
$(document).on('click','.extra_business',function(){
    var id = $(this).data('id');
    $('.extra_business_button_'+id).show();
});   

$(document).on('click','.add_extra_business',function(){

    var id = $(this).data('id');
    var amount = $('.amount_extra_business_'+id).val();
    var store_id = $(this).data('store');

    $.ajax({
        url: "/sales-history/save-medical-store-amount",
        type: "POST",
        data:{ 
            'amount' : amount,
            'type' : 2,
            'id' : id,
            'store_id' : store_id
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Amount Successfully Change');
                $('.extra_business_button_'+id).hide();
            }else{
                toastr.error('Amount exceeded total sales');
            }
        }
    });

});

$(document).on('click','.remove_extra_business',function(){
    var id = $(this).data('id');
    $('.extra_business_button_'+id).hide();
    var get_value = $('.amount_extra_business_'+id).val();
    console.log(get_value); 
    var value = $('.amount_extra_business_'+id).data('value');
    console.log(value); 
    $('.amount_extra_business_'+id).val(value);
});  
//end

//scheme business
$(document).on('click','.scheme_business',function(){
    var id = $(this).data('id');
    $('.scheme_business_button_'+id).show();
});   

$(document).on('click','.add_scheme_business',function(){

    var id = $(this).data('id');
    var amount = $('.amount_scheme_business_'+id).val();
    var store_id = $(this).data('store');

    $.ajax({
        url: "/sales-history/save-medical-store-amount",
        type: "POST",
        data:{ 
            'amount' : amount,
            'type' : 3,
            'id' : id,
            'store_id' : store_id
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Amount Successfully Change');
                $('.scheme_business_button_'+id).hide();
            }else{
                toastr.error('Amount exceeded total sales');
            }
        }
    });

});

$(document).on('click','.remove_scheme_business',function(){
    var id = $(this).data('id');
    $('.scheme_business_button_'+id).hide();
    var get_value = $('.amount_scheme_business_'+id).val();
    console.log(get_value); 
    var value = $('.amount_scheme_business_'+id).data('value');
    console.log(value); 
    $('.amount_scheme_business_'+id).val(value);
});  
//end

//ethical business
$(document).on('click','.ethical_business',function(){
    var id = $(this).data('id');
    $('.ethical_business_button_'+id).show();
});   

$(document).on('click','.add_ethical_business',function(){

    var id = $(this).data('id');
    var amount = $('.amount_ethical_business_'+id).val();
    var store_id = $(this).data('store');

    $.ajax({
        url: "/sales-history/save-medical-store-amount",
        type: "POST",
        data:{ 
            'amount' : amount,
            'type' : 4,
            'id' : id,
            'store_id' : store_id
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Amount Successfully Change');
                $('.ethical_business_button_'+id).hide();
            }else{
                toastr.error('Amount exceeded total sales');
            }
        }
    });

});

$(document).on('click','.remove_ethical_business',function(){
    var id = $(this).data('id');
    $('.ethical_business_button_'+id).hide();
    var get_value = $('.amount_ethical_business_'+id).val();
    console.log(get_value); 
    var value = $('.amount_ethical_business_'+id).data('value');
    console.log(value); 
    $('.amount_ethical_business_'+id).val(value);
});  
//end
