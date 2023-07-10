$("#changePassword").validate({
    errorElement : 'span',
    rules: {
        old_pass: {
            required: true,
            minlength: 6
        },
        new_pass: {
            required: true,
            minlength: 6
        },
        confirm_password : {
            required: true,
            minlength: 6,
            equalTo: "#inputNewPassword"
        }

    },
    messages: {
        old_pass: {
            required: "Please enter current password",
        },
        new_pass:{
            required: "Please enter new password",
        },
        confirm_password:{
            required: "Please enter confirm password",
            equalTo: "The new passwords do not match. Please check again"
        }
    }
});