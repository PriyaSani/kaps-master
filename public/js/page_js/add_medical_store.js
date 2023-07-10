var selected = [];
$(document).on('change','.sub_territories',function(){
    
    $.each($(".sub_territories option:selected"), function(){            

        var id = $(this).val();
        if(jQuery.inArray(id, selected) !== -1){            

        } else {

           selected.push(id);

        }
        
    });
    console.log(selected);
});

$(document).ready(function() {
  $(".sub_territories").select2();
  $(".sub_territories").data('originalvalues', []);
  $(".sub_territories").on('change', function(e) {
    var that = this;
    removed = []
    
    $($(this).data('originalvalues')).each(function(k, v) {
      if (!$(that).val()) {
        removed[removed.length] = v;
        return false;
      }
      if ($(that).val().indexOf(v) == -1) {
        removed[removed.length] = v;
      }
    });
    
    
    if ($(this).val()) {
      $(this).data('originalvalues', $(this).val());
    } else {
      $(this).data('originalvalues', []);
    }
    selected.splice($.inArray(removed, selected), 1);
    selected = selected.filter(function(item) {
        return !removed.includes(item); 
    })
    console.log("Removed: " + removed)
    console.log(selected);
  });
});

$(document).on('change','.territories',function(){
    var territories = $(this).val();
    if(territories != ''){
        $.ajax({
            url: "/get-sub-territories",
            method:'POST',
            data:{ territories: territories},
            success: function(data){
                
                $('.sub_territories').html(data);
                $(".sub_territories").val(selected).trigger('change');
            }
        });
    }else{
        /*$(".sub_territories").val('');*/
        
        $(".sub_territories").val('').trigger('change');

        $.each($(".sub_territories option:selected"), function(){            

            var id = $(this).val();
            if(jQuery.inArray(id, selected) !== -1){            
                selected = [];
            } else {
                selected = [];       

            }
            
        });
    }
});

$(document).on('keypress','#inputUserName',function(){
    var added_user_id = $('.added_user_id').val();
    $.ajax({
        url: "/get-associated-user",
        type: "POST",
        data:{ name: $(this).val(),value:added_user_id},
        success: function(data){
            autocompletedatalist = data;
            $('#inputUserName').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    //event.preventDefault();
                    $('#inputUserName').val(ui.item.label);
                    $('#client_id').val(ui.item.value);
                    var added_user_id = $('.added_user_id').val();
                    $.ajax({
                        url: "/get-associated-user-row",
                        type: "POST",
                        data:{ 
                            id: ui.item.value,
                            value:added_user_id
                        },
                        success: function(data){
                           $('#userData').append(data.html);
                           $('.added_user_id').val(data.count);
                           $('#inputUserName').val('');
                        }
                    });
                    return false;
                }
            });
        }
    });
});

$(document).on('click','.deleteThisRow',function(){
    var arr = $('.added_user_id').val();
    var user_id = $(this).data('id');
    arr = jQuery.parseJSON(arr);
    var result = arr.filter(function(elem){
       return elem != user_id; 
    });
    $(this).closest('.user_dynamic_row').remove();
    $('.added_user_id').val(JSON.stringify(result));
});

$(document).on('click','.addNewUser',function(){
    $('.exampleModal').modal('show');
    $('.exampleModal').modal({
        backdrop: 'static',
        keyboard: false
    });
});

$(document).on('click','.btn-primary',function(){
    var valid = $("#saveUserContact").valid();
    console.log(valid);
    if(valid == true){
        $('.exampleModal').modal('hide');
    }
});

$(document).on('submit','#saveUserContact',function(e){
    e.preventDefault();
    var added_user_id = $('.added_user_id').val();
    
    $.ajax({
        url: "/add-associated-user",
        type: "POST",
        data:{
            name : $('#modal_name').val(),
            email : $('#modal_email').val(),
            mobile : $('#modal_mobile').val(),
            type : $('#modal_type').val(),
            user_type : 1,
            value:added_user_id
        },
        success: function(data){
            $('#saveUserContact')[0].reset();
            $('#exampleModal').modal('hide');
            $('.added_user_id').val(data.count);
            $('#userData').append(data.html);
        }
    });

});

$.validator.addMethod("customemail", 
    function(value, element) {
        if(value == ""){
            return true;
        }else{
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);    
        }
    }, 
    "Please Enter Email ID Along with Domain Name."
);

$("#saveUserContact").validate({
    errorElement: 'span',
    rules: {
        name: {
            required: true,
        },
        email: {
            email: true,
            customemail : true,
            remote:{
                url: "/check-email-id",
                type: "post",
            }
        },
        mobile: {
            required: true,
            minlength:10,
            maxlength:10,
            remote:{
                url: "/check-contact-number",
                type: "post",
            }
        },
    },
    messages: {
        name:{
            required:"Please Enter Name",
        },
        email:{
            email:"Please Enter Valid Email Address",
            remote:"Email ID Already Exists!",
        },
        mobile:{
            required:"Please Enter Mobile",
            remote:"Mobile Already Exists!",
            minlength:"Please Enter 10 Digit Mobile",
            maxlength:"Please Enter 10 Digit Mobile",
        }
    }
});