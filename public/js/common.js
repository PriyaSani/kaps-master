$('.alphanumeric').keyup(function() {
    if (this.value.match(/[^a-zA-Z0-9]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
    }
});


$(document).on('keypress','.state_name',function(){
	
    $.ajax({
        url: "/administrator-panel/get-state",
        type: "POST",
        dataType: "JSON",
        success: function(data){
            autocompletedatalist = data;
            $('.state_name').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                    this.new_value = ui.item.label;
                },
                select: function(event, ui) {
                    event.preventDefault();
                    $('.state_name').val(ui.item.label);
                    $('#state_id').val(ui.item.value);
                    $('.state_code').val(ui.item.new_value);
                    return false;
                },
            });
        }
    });
});

$(document).on('keypress','.country',function(){
	
    $.ajax({
        url: "/administrator-panel/get-country",
        type: "POST",
        dataType: "JSON",
        success: function(data){
            autocompletedatalist = data;
            $('.country').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    event.preventDefault();
                    $('.country').val(ui.item.label);
                    $('#country_id').val(ui.item.value);
                    return false;
                },
            });
        }
    });
});