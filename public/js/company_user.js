$(document).on('change','.user_type',function(){
	if($(this).val() == 2){
		$('.departments').show();
		$('#departments').attr('required',true);
	} else {
		$('.departments').hide();
		$('#departments').attr('required',false);
	}
});

$(document).on('keypress','#name',function(){
    $.ajax({
        url: "/administrator-panel/company/get-employee-suggestion",
        type: "POST",
        dataType: "JSON",
        data:{ 
            company_id : $('#company_id').val()
        },
        success: function(data){
            autocompletedatalist = data;
            $('#name').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    //event.preventDefault();
                    $('#name').val(ui.item.label);
                    $('#employee_id').val(ui.item.value);
                    $.ajax({
                        url: "/administrator-panel/company/employee-details",
                        type: "POST",
                        data:{ 
                            id: ui.item.value,
                        },
                        success: function(data){
                           $('#employee_id').val(data.id);
                           $('#name').val(data.name);
                           $('#mobile').val(data.mobile);
                           $('#email').val(data.email);
                           $('.password').hide();
                           $('#password').attr('required',false);
                           $('#confirm_password').attr('required',false);
                        }
                    });
                    return false;
                }
            });
        }
    });
});