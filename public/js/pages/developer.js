$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on("input", ".number", function() {
    this.value = this.value.replace(/\D/g,'');  
});

$(document).on("input", ".amount", function() {
    this.value = this.value.replace(/[^0-9\.]/g,"");  
});

$('.numinput').on('input', function() {
      this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1'); 
});

$('.dropify').dropify();