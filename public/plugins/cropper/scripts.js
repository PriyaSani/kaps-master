$("#item-img-output").click(function() {
    $("input[id='my_file']").click();
});

var $uploadCrop,tempFilename,rawImg,imageId;

function readFile(input) {
        if (input.files && input.files[0]) {
      var reader = new FileReader();
        reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
            $('.exampleModal').modal('show');
            $('#exampleModalLabel').text('Crop Image');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
    else {
        swal("Sorry - you're browser doesn't support the FileReader API");
    }
}

$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 120,
        height: 120,
        type: 'circle'
    },
    enforceBoundary: true,
    enableExif: false
});

$('.exampleModal').on('shown.bs.modal', function(){
    // alert('Shown pop');
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function(){
        console.log('jQuery bind complete');
    });
});

$('.item-img').on('change', function() {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});

$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {width: 120, height: 120}
    }).then(function (resp) {
        $.ajax({
            url: "/client/crop-image",
            type: "POST",
            data: {"image":resp},
            success: function (data) {
                $('#profile_image').val(data.file);
            }
        });
        $('#item-img-output').attr('src', resp);
        $('.exampleModal').modal('hide');
    });
});