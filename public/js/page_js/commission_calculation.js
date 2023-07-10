$('.new_commission').keyup(function(){
  if ($(this).val() > 100){
    $(".new_commission").val('');
    $(".new_commission_error").css("display", "block");
    $(".new_commission_error").html("Enter valid Reward");
    $('.new_commission_error').fadeIn();
    $('.new_commission_error').fadeOut(4000);
    // $(this).val('100');
  }
});

$('.update_commission').keyup(function(){
    var id = $(this).data('id');
  if ($(this).val() > 100){
    $(this).val('');
    
    $(".commission_error_"+id).css("display", "block");
    $(".commission_error_"+id).html("Enter valid Reward");
    $('.commission_error_'+id).fadeIn();
    $('.commission_error_'+id).fadeOut(4000);
    // $(this).val('100');
  }
});



$( document ).ready(function() {
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        ((''+month).length<2 ? '0' : '') + month + '-' +
        ((''+day).length<2 ? '0' : '') + day;
    console.log(output);
    $('.new_start_date').datepicker('setStartDate', output);

});

$( document ).ready(function() {

    var start_date = $('.commission_start_date').val();
    console.log(start_date);
    var arr = start_date.split("/");
    var date1 = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
    var d = date1.getDate();
    var m = date1.getMonth();
    var y = date1.getFullYear();
    var start_date = new Date(y, m, d);
    console.log(start_date);
    if(start_date != ''){
        $('.commission_end_date').datepicker('setStartDate', start_date);
    }

});

$(document).on('change', '.new_start_date', function(){

    var date = $(this).val();

    var arr = date.split("/");
    var date1 = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
    var d = date1.getDate();
    var m = date1.getMonth();
    var y = date1.getFullYear();
    var start_date = new Date(y, m, d);
    if(date != ''){
        $('.new_end_date').datepicker('setStartDate', start_date);
        // $("#proj_err").css("display", "none");
        $(".new_end_date").val('');
    }

    if(date != ''){
        $.ajax({
            url: "/doctor/check-commission-date",
            method:'POST',
            data:{ date: date},
            success: function(data){
                if(data == 'true'){
                    
                }else{
                    $(".new_start_date").val(''); 
                    toastr.error('Please Enter Valid Date');
                                   
                }
            }
        });
    }
});

$(document).on('change', '.commission_start_date', function(){

    var date = $(this).val();
    var id = $(this).data('id');

    var arr = date.split("/");
    var date1 = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
    var d = date1.getDate();
    var m = date1.getMonth();
    var y = date1.getFullYear();
    var start_date = new Date(y, m, d);
    console.log(start_date);
    if(date != ''){
        $('.commission_end_date').datepicker('setStartDate', start_date);
        // $("#proj_err").css("display", "none");
        // $(".new_end_date").val('');
    }

    if(date != ''){
        $.ajax({
            url: "/doctor/check-commission-date",
            method:'POST',
            data:{ date: date,id: id},
            success: function(data){
                if(data == 'true'){
                    
                }else{
                    $(".new_start_date").val(''); 
                    toastr.error('Please Enter Valid Date');
                                   
                }
            }
        });   
    }
});


$(".add_commission_btn").click(function() {
    $(".add_commission").show("slow");

    var date = $(".new_start_date").val();

    var arr = date.split("/");
    var date1 = new Date(arr[2]+"-"+arr[1]+"-"+arr[0]);
    var d = date1.getDate();
    var m = date1.getMonth();
    var y = date1.getFullYear();
    var start_date = new Date(y, m, d);
    if(date != ''){
        $('.new_end_date').datepicker('setStartDate', start_date);
        // $("#proj_err").css("display", "none");
        $(".new_end_date").val('');
    }

});

$(document).ready(function() {
// Submit form with id function.

    $('form').on('submit', function (e){
    
        e.preventDefault();
        var start_date = $(".new_start_date").val();
        var commission = $(".new_commission").val();
        
        if((start_date != '') && (commission != '')){
            console.log('here');
            e.currentTarget.submit();
            
        }else{

            if(start_date == ''){

                $(".new_start_date_error").css("display", "block");
                $(".new_start_date_error").html("Enter Start Date");
                $('.new_start_date_error').fadeIn();
                $('.new_start_date_error').fadeOut(4000);
            }

            if(commission == ''){

                $(".new_commission_error").css("display", "block");
                $(".new_commission_error").html("Enter Reward");
                $('.new_commission_error').fadeIn();
                $('.new_commission_error').fadeOut(4000);
            }
        }
    
    });
});

$(".update_commission").click(function() {

    var id = $(this).data('id');
    var doctor_id = $(this).data('doctor');
    var profile_id = $(this).data('profile');

    var start_date = $('.start_date_'+id).val();
    var end_date = $('.end_date_'+id).val();
    var commission = $('.commission_'+id).val();

    if((start_date != '') && (commission != '')){

        $.ajax({
            url: "/doctor/update-doctor-commission",
            method:'POST',
            data:{ id: id,doctor_id:doctor_id,profile_id:profile_id,start_date:start_date,end_date:end_date,commission:commission},
            success: function(data){
                console.log(data);
                if(data == 'true'){
                    toastr.success('Doctor Reward Successfully Updated');
                }else{
                    toastr.success('Something Went Wrong!');
                }
            }
        });
    }else{
        console.log('here');
        if(start_date == ''){
            console.log('here1');
            $(".start_date_error_"+id).css("display", "block");
            $(".start_date_error_"+id).html("Enter Start Date");
            $('.start_date_error_'+id).fadeIn();
            $('.start_date_error_'+id).fadeOut(4000);
            // document.getElementsByClassName('start_date_error_'+id).innerHTML="Enter Start Date!";
        }

        if(commission == ''){
            console.log('here2');
            $(".commission_error_"+id).css("display", "block");
            $(".commission_error_"+id).html("Enter Reward");
            $('.commission_error_'+id).fadeIn();
            $('.commission_error_'+id).fadeOut(4000);
            // document.getElementsByClassName('commission_error_'+id).innerHTML="Enter Start Date!";
        }    
    }

});