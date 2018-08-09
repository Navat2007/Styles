$(document).ready(function (){      
    
    $('#add_theme_button_close').click(function (event)
    {            
        funcSuccess();
    });
    
    $('#add_theme_button_create').click(function (event)
    {          
        event.preventDefault();
        
        $('#error').html("");   
        
        var theme_name = $("#theme_add_name").val();
        
        if(theme_name === "")
        {
            $('#error').text('Введите название темы!');
            return;
        }
        
        $.ajax(
        {
            url: "theme_add_data.php",
            type: 'POST',            
            data: 
            {
                title: theme_name
            },
            dataType: "html",
            beforeSend: funcWait,
            success: funcSuccess   
        });         
    });
});

function funcWait()
{
    $('#error').text("Ожидание...");
}

function funcSuccess(data)
{        
    $(".modal").css("display", "none"); 
    addThemeWindowOpen = 0;
    $('#modal_window').load("blank.php"); 
    
    loadThemes();  
}