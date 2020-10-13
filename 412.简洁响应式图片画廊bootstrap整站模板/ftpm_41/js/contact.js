jQuery.noConflict()(function($){
$(document).ready(function ()
{ // after loading the DOM
    $("#ajax-contact-form").submit(function ()
    {
        // this points to our form
        var str = $(this).serialize(); // Serialize the data for the POST-request
        $.ajax(
        {
            type: "POST",
            url: "contact.php",
            data: str,
            success: function (msg)
            {
                $("#note").ajaxComplete(function (event, request, settings)
                {
                    if (msg == 'OK') // If a message is sent, the user thanks
                    {
                        result = '<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>Message was sent to website administrator. Thank you!</div>';
                        $("#fields-main").hide();
                    }
                    else
                    {
                        result = msg;
                    }
                    $(this).html(result);
                });
            }
        });
        return false;
    });

});
});