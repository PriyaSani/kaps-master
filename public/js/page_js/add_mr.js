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