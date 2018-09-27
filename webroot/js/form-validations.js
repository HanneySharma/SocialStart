$(document).ready(function(){
 $('#add_organization').validate({
        rules: {
            formal_company_name: {
                required: true
            },
            category: {
              required: true,
            }
            
        },
        messages: {
            formal_company_name: {
                required: "Enter Company Name",
            },
            category: {
              required: "Select Category",
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    });

 $('#addUsers').validate({
        rules: {
            name: {
                required: true
            },
            username: {
                required: true,
                email: true
            }, 
            password: {
                required: true,
            }             
        },
        messages: {
            name: {
                required: "Enter User  Name",
            },
            username: {
                required: "Enter User Email",
                email:  "Enter Valid Email"
            },
           password: {
              required: "Enter User Password",
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    }); 
 $('#usersGroup').validate({
        rules: {
            name: {
                required: true
            }             
        },
        messages: {
            name: {
                required: "Enter Group Name",
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    });


  $('#addReadList').validate({
        rules: {
            title: {
                required: true
            },
            link: {
                required: true,
                url: true
            }             
        },
        messages: {
            title: {
                required: "Enter Title",
            },
            link: {
                required: "Enter Url",
                url:  "Enter Valid Url"
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    });



    $('#resetPassword').validate({
        rules: {
            password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }             
        },
        messages: {
            password: {
                required: "Enter Password",
            },
            confirm_password: {
                required: "Enter Confirm Password",
                equalTo: "Confirm password does not match",
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    });

 });