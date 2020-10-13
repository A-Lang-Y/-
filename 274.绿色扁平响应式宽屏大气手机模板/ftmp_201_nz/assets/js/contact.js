jQuery.noConflict()(function($){
$(document).ready(function ()
{ // после загрузки DOM
    $("#ajax-contact-form").submit(function ()
    {
        // this указывает на нашу форму
        var str = $(this).serialize(); // сериализуем данные для POST-запроса
        $.ajax(
        {
            type: "POST",
            url: "contact.php",
            data: str,
            success: function (msg)
            {
                $("#note").ajaxComplete(function (event, request, settings)
                {
                    if (msg == 'OK') // Если сообщение отправлено, поблагодарим пользователя
                    {
                        result = '<div class="notification_ok">Message was sent to website administrator, thank you!</div>';
                        $("#fields").hide();
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