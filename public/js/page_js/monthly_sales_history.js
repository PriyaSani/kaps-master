$(document).on('click','.change_amount',function(){
    var id = $(this).data('id');
    $('.save_'+id).show();
});   

$(document).on('click','.add_amount',function(){

    var id = $(this).data('id');
    var amount = $('.amount_'+id).val();

    $.ajax({
        url: "/sales-history/save-stockist-amount",
        type: "POST",
        data:{ 
            'amount' : amount,
            'id' : id
        },
        success: function(data){
            if(data == 'true'){
                toastr.success('Amount Successfully Change');
                $('.save_'+id).hide();
            }else{
                toastr.error('Something Wrong');
            }
        }
    });

});

$(document).on('click','.remove_amount',function(){
    var id = $(this).data('id');
    $('.save_'+id).hide();
    var get_value = $('.amount_'+id).val();
    console.log(get_value); 
    var value = $('.amount_'+id).data('value');
    console.log(value); 
    $('.amount_'+id).val(value);
});  

$(document).on('click', '.statement', function(){
    var id = $(this).data('id');
    
    $.ajax({
        type: 'post',
        url: "/sales-history/stockist-statement",
        data: {
            'id': id
        },
        success: function(data) {
           $('#modalcontent').html(data);
            
        }
    });

});