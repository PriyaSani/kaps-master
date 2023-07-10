$(".cgst").keyup(function(){

    var cgst = parseInt($(this).val());
    var sgst = parseInt($('.sgst').val());
    
    var total_gst = sgst + cgst;
    $('.gst').val(total_gst);
});

$(".sgst").keyup(function(){

    var cgst = parseInt($('.cgst').val());
    var sgst = parseInt($(this).val());
    
    var total_gst = sgst + cgst;
    $('.gst').val(total_gst);
});

$(document).on('change','.taxation_type',function(){
    var taxation_type = $(this).val();

    if(taxation_type == 1){
        $('.tax_taxation').hide();
        $(".tax").attr('required',false);
    }else{
        $('.tax_taxation').show();

        $(".tax").attr('required',true);
    } 
});