 $('#add_organization').validate({
        rules: {
            formal_company_name: {
                required: true
            },
            legal_company_name: {
                required: true
            }, 
            first_name: {
                required: true,
            }, 
            last_name: {
                required : true,
            },
           email: {
               required : true,
            }
            
        },
        messages: {
            formal_company_name: {
                required: "Enter Company Name",
            },
            legal_company_name: {
                required: "Enter Legal Company Name",
            },
            first_name: {
                required: "Enter Ceo First Name",
            },
            last_name: {
                required: "Enter Ceo Last Name",
            },
           email: {
              required: "Enter Ceo Email",
            },
           city: {
              required: "Select City",
            },
           state: {
              required: "Select State",
            },
           country: {
              required: "Select Country",
            },
           category: {
              required: "Select Category",
            }
        },
        errorPlacement: function(error, element){
            error.insertAfter(element);
        }
    });

 