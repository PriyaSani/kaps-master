$(document).ready(function() {

    //custom validation method
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

    // validate signup form on keyup and submit
    $("#territoryForm").validate({
        errorElement: 'span',
        rules: {
            territory_id: {
                required: true,
                remote:{
                    url: "/territory/check-territory-priority",
                    type: "post",
                    data:{
                        state : function() {
                            return $('.state_name').val()
                        },
                        territory_id : function() {
                            return $('.territory_name').val()
                        },
                        id : function() {
                            return $('.id').val()
                        },
                    }
                }
            },
            state_id:{
                required: true,
                remote:{
                    url: "/territory/check-territory-priority",
                    type: "post",
                    data:{
                        state : function() {
                            return $('.state_name').val()
                        },
                        territory_id : function() {
                            return $('.territory_name').val()
                        },
                        id : function() {
                            return $('.id').val()
                        },
                    }
                }
            }
        },
        messages: {
            territory_id: {
                required: 'Enter Territory',
                remote:'Territory Already Exists!'
            },
            state_id: {
                required: 'Select State',
                remote:'State Already Exists!'  
            }
        }
    });
   
    $("#subTerritoryForm").validate({
        errorElement: 'span',
        rules: {
            sub_territory: {
                required: true,
                remote:{
                    url: "/territory/check-sub-territory-priority",
                    type: "post",
                    data:{
                        sub_territory : function() {
                            return $('.sub_territory').val()
                        },
                        territory_id : function() {
                            return $('.territory_id').val()
                        },
                        id : function() {
                            return $('.id').val()
                        },
                    }
                }
            }
        },
        messages: {
            sub_territory: {
                required: 'Enter Sub Territory',
                remote:'Sub Territory Already Exists!'
            }
        }
    });

    $("#addEmployee").validate({
        errorElement: 'span',
        rules: {
            full_name: {
                required: true
            },
            address: {
                required: true  
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10    
            },
            password:{
                minlength: 8,
            },
            email_id: {
                required: true,
                email: true,
                customemail : true,
                remote:{
                    url: "/employee/check-email-exists",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#employee_id').val()
                        },
                    }
                }
            },
            confirm_password:{
                minlength: 8,
                equalTo:"#password"  
            },
            'territories[]':{
                required: true,
            },
            'sub_territories[]':{
                required: true,
            },
            'module[]':{
                required: true,
            }
            
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'module[]'){ 
                error.insertAfter('#module');
            }else if(element.attr("name") == 'territories[]'){ 
                error.insertAfter('#territories');
            }else if(element.attr("name") == 'sub_territories[]'){ 
                error.insertAfter('#sub_territories');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            full_name: {
                required: 'Enter Full Name'
            },
            address: {
                required: 'Enter Address'  
            },
            mobile_number: {
                required: 'Enter Mobile Number',    
                minlength:"Enter Minimum 10 Digit Mobile Number",
                maxlength:"Enter Minimum 10 Digit Mobile Number",
            },
            email_id: {
                required: 'Enter Email ID',
                email: 'Enter Valid Email ID',
                remote:'Email ID Already Exists'
            },
            password:{
               minlength:"Enter Minimum 8 Character"
            },
            confirm_password:{
                equalTo:"The New Passwords do Not Match. Please Check Again",
                minlength:"Enter Minimum 8 Character"
            },
            'territories[]':{
                required: 'Select Atleast one Territory',
            },
            'sub_territories[]':{
                required: 'Select Atleast one Sub Territory',
            },
            'module[]':{
                required: 'Select Atleast one Module from List',
            }
        }
    });

    $("#mrForm").validate({
        errorElement: 'span',
        rules: {
            full_name: {
                required: true
            },
            address: {
                required: true  
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10    
            },
            password:{
                minlength: 8,
            },
            email_id: {
                required: true,
                email: true,
                customemail : true,
                remote:{
                    url: "/mr/check-mr-email-exists",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#mr_id').val()
                        },
                    }
                }
            },
            confirm_password:{
                minlength: 8,
                equalTo:"#password"  
            },
            'territories[]':{
                required: true,
            },
            'sub_territories[]':{
                required: true,
            }
            
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'territories[]'){ 
                error.insertAfter('#territories');
            }else if(element.attr("name") == 'sub_territories[]'){ 
                error.insertAfter('#sub_territories');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            full_name: {
                required: 'Enter Full Name'
            },
            address: {
                required: 'Enter Address'  
            },
            mobile_number: {
                required: 'Enter Mobile Number',    
                minlength:"Enter Minimum 10 Digit Mobile Number",
                maxlength:"Enter Minimum 10 Digit Mobile Number",
            },
            email_id: {
                required: 'Enter Email ID',
                email: 'Enter Valid Email ID',
                remote:'Email ID Already Exists'
            },
            password:{
               minlength:"Enter Minimum 8 Character"
            },
            confirm_password:{
                equalTo:"The New Passwords do Not Match. Please Check Again",
                minlength:"Enter Minimum 8 Character"
            },
            'territories[]':{
                required: 'Select Atleast one Territory',
            },
            'sub_territories[]':{
                required: 'Select Atleast one Sub Territory',
            }
        }
    });

    $("#doctorForm").validate({
        errorElement: 'span',
        rules: {
            full_name: {
                required: true
            },
            specialization: {
                required: true  
            },
            mobile_number: {
                minlength: 10,
                maxlength: 10,
                remote:{
                    url: "/doctor/check-doctor-mobile-exists",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#doctor_id').val()
                        },
                    }
                }
            },
            email: {
                email: true,
                customemail : true,
                remote:{
                    url: "/doctor/check-doctor-email-exists",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#doctor_id').val()
                        },
                    }
                }
            },
            'territories[]':{
                required: true,
            },
            'sub_territories[]':{
                required: true,
            }
            
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'territories[]'){ 
                error.insertAfter('#territories');
            }else if(element.attr("name") == 'sub_territories[]'){ 
                error.insertAfter('#sub_territories');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            full_name: {
                required: 'Enter Full Name'
            },
            specialization: {
                required: 'Enter Specializatiion'  
            },
            mobile_number: {
                required: 'Enter Mobile Number',    
                minlength:"Enter Minimum 10 Digit Mobile Number",
                maxlength:"Enter Minimum 10 Digit Mobile Number",
                remote:"Mobile Number Already Exists"
            },
            email: {
                required: 'Enter Email ID',
                email: 'Enter Valid Email ID',
                remote:'Email ID Already Exists'
            },
            'territories[]':{
                required: 'Select Atleast one Territory',
            },
            'sub_territories[]':{
                required: 'Select Atleast one Sub Territory',
            }
        }
    });

    $("#medicalStoreForm").validate({
        errorElement: 'span',
        rules: {
            store_name: {
                required: true
            },
            store_email_id: {
                email : true,
                customemail : true
            },
            gst_number: {
                remote:{
                    url: "/medical-store/store-gst-number",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#medical_store_id').val()
                        },
                    }
                }
            },
            'territories[]':{
                required: true,
            },
            'sub_territories[]':{
                required: true,
            }
            
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'territories[]'){ 
                error.insertAfter('#territories');
            }else if(element.attr("name") == 'sub_territories[]'){ 
                error.insertAfter('#sub_territories');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            store_name: {
                required: 'Enter Store Name'
            },
            store_email_id: {
                email : 'Enter Valid Email ID',
            },
            gst_number:{
                remote:'GST Number Already Exists'
            },
            'territories[]':{
                required: 'Select Atleast one Territory',
            },
            'sub_territories[]':{
                required: 'Select Atleast one Sub Territory',
            }
        }
    });

    $("#stockiestForm").validate({
        errorElement: 'span',
        rules: {
            stockiest_name: {
                required: true
            },
             stockiest_email_id: {
                email: true,
                customemail : true,
            },
            gst_number: {
                remote:{
                    url: "/stockiest/stockiest-gst-number",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#stockiest_id').val()
                        },
                    }
                }
            },
            'territories[]':{
                required: true,
            },
            'sub_territories[]':{
                required: true,
            }
            
        },
        errorPlacement: function(error, element) {
            
            if(element.attr("name") == 'territories[]'){ 
                error.insertAfter('#territories');
            }else if(element.attr("name") == 'sub_territories[]'){ 
                error.insertAfter('#sub_territories');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            stockiest_name: {
                required: 'Enter Stockiest Name'
            },
            stockiest_email_id: {
                email: 'Enter Valid Email ID'
            },
            gst_number:{
                remote:'GST Number Already Exists'
            },
            'territories[]':{
                required: 'Select Atleast one Territory',
            },
            'sub_territories[]':{
                required: 'Select Atleast one Sub Territory',
            }
        }
    });

    $("#saveDoctorProfile").validate({
        errorElement: 'span',
        rules: {
            profile_name: {
                required: true,
                remote:{
                    url: "/doctor/check-doctor-profile",
                    type: "post",
                    data:{
                        id : function() {
                            return $('#id').val()
                        },
                    }
                }
            }
        },
        messages: {
            profile_name: {
                required: 'Enter Profile Name',
                remote:'Profile Already Exists'
            }
        }
    });

    $("#saveDoctorOffset").validate({
        errorElement: 'span',
        rules: {
            last_month_sales: {
                required: true
            },
            previous_second_month_sales: {
                required: true
            },
            previous_third_month_sales:{
                required: true
            },
            target_previous_month:{
                required: true
            },
            carry_forward:{
                required: true
            },
            eligible_amount:{
                required: true
            }
            
        },
        messages: {
            last_month_sales: {
                required: 'Enter Monthly Sales'
            },
            previous_second_month_sales: {
                required: 'Enter Monthly Sales'
            },
            previous_third_month_sales:{
                required:'Enter Monthly Sales'
            },
            target_previous_month:{
                required:'Enter Target'
            },
            carry_forward:{
                required:'Enter Carry Forward'
            },
            eligible_amount:{
                required:'Enter Eligible Amount'
            }
        }
    });

});


