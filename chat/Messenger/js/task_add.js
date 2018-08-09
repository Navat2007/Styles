$(document).ready(function ()
{ 
    var confirm = $('#task_add_confirm_button');
    var error = $('#task_add_error');   
    
    // Клик по кнопке "Добавить" во карточке добавления задания
    confirm.click(function (event)
    {           
        event.preventDefault();

        error.html("");   
        var title = $("#task_add_textArea").val();

        if(title === "")
        {
            error.text('Введите название задачи!');
            return;
        }

        $.ajax(
        {
            url: "task_add_data.php",
            type: 'POST',            
            data: 
            {
                title: title,
                themeID: CURRENT_THEME_ID    
            },
            dataType: "html",
            success: function (data)
            { 
                chatSendMessage("<span><b>" + CURRENT_USER_NAME + "</b> добавил задачу &laquo;" + title + "&raquo; </span>", 1);
                $("#new_task_window").remove();
                task_add_Window = false;

                loadTaskNeed();
            }   
        });    
    });
});