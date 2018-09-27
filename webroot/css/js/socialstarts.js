$(document).ready(function(){
    //To change the form for cron settings drop down value
    $(document).on('change','#service_type',function(){
        var service_type = $( "#service_type" ).val();
        var url = siteURL+"users/settings"; // the script where you handle the form input.
        formData = "service_type="+service_type;

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            beforeSend: function(){                
                 $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
             },                
            success: function(data)
            {
                $("#divUpdate").html(data);
            }
        });
    });
    
    // this is the id of the form
    $("#search_button").click(function(e) {

        var url = siteURL+"organizations/index"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: $("#search_organizations").serialize(), // serializes the form's elements.
               beforeSend: function(){                
                    $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
                },   
               success: function(data)
               {
                    $("#divUpdate").html(data);
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#search_button_crunch").click(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var url = siteURL+"organizations/index"; // the script where you handle the form input.
        $.ajax({
               type: "POST",
               url: url,
               data: $('#search_organizations_crunch').serialize(), // serializes the form's elements.
               beforeSend: function(){                
                    $("#divUpdate").html('<div class="fa fa-circle-o-notch fa-spin"></div>');
                },   
               success: function(data)
               {
                    $("#divUpdate").html(data);
               }
             });

    });

}); 