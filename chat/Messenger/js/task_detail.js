$(document).ready(function ()
{    
    var title_text = $('#task_add_textArea');
    var description_text = $('#task_detail_desc');
    var date_text = $('#task_detail_date');
    
    // "Описание" 
    $('#task_detail_desc_add_btn').click(function (event)
    {  
        if(description_text.css('display') === 'none')
        {
            description_text.val('');
            taskSendMessage(CURRENT_USER_NAME + " добавил описание к задаче.", 1);
        }
        
        $('#task_detail_desc_label').css('display', 'flex');
        description_text.css('display', 'flex');
    });     
    $('#task_detail_desc_close').click(function (event)
    {  
        $('#task_detail_desc_label').css('display', 'none');
        $('#task_detail_desc').css('display', 'none');
        description_text.val('');
        taskSendMessage(CURRENT_USER_NAME + " удалил описание к задаче.", 1);
    }); 
    
    // "Срок" 
    $('#task_detail_date_add_btn').click(function (event)
    {    
        if(date_text.css('display') === 'none')
        {
            date_text.val('');
            taskSendMessage(CURRENT_USER_NAME + " добавил cрок к задаче.", 1);
        }
        
        $('#task_detail_date_label').css('display', 'flex');
        date_text.css('display', 'flex');
    });     
    $('#task_detail_date_close').click(function (event)
    {  
        $('#task_detail_date_label').css('display', 'none');
        date_text.css('display', 'none');
        date_text.val('');
        taskSendMessage(CURRENT_USER_NAME + " удалил cрок к задаче.", 1);
    }); 
    
    // "Архивировать" 
    $('#task_detail_archive_btn').click(function (event)
    {    
        swal({
            title: 'Вы уверены что хотите оправить задачу в архив?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да',
            cancelButtonText: 'Нет'
        }).then((result) => 
        {
            if (result.value) 
            {
                $.ajax(
                {
                    url: "task_detail_save.php",
                    type: 'POST',            
                    data: 
                    {
                        action: "archive",
                        task_id: CURRENT_TASK_ID   
                    },
                    dataType: "html",
                    success: function (data)
                    {       
                        swal({
                            type: 'success',
                            title: 'Задача ' + title_text.val() + ' в архиве.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        closeTask();
                        chatSendMessage("<span><b>" + CURRENT_USER_NAME + "</b> отправил задачу &laquo;" + title_text.val() + "&raquo; <b>&rArr; " + "Архив" + "</b></span>", 1);
                    } 
                });  
            }
        });
    }); 
    
    // "Сохранить"
    $('#task_detail_save').click(function (event)
    {  
        $.ajax(
        {
            url: "task_detail_save.php",
            type: 'POST',            
            data: 
            {
                action: "save",
                title: title_text.val(),
                desc: description_text.val(),
                date: date_text.val(),
                task_id: CURRENT_TASK_ID   
            },
            dataType: "html",
            success: function (data)
            {       
                closeTask();
            } 
        });  
    });
    
    // "Выйти"
    $('.back').click(function (event)
    {  
        closeTask();
    }); 
});