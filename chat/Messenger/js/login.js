$(document).ready(function ()
{       
    $('#buttonRegistration').click(function (event)
    {  
        $('#container').load("add_user.php");   
    });
    
    $('#buttonLogin').click(function (event)
    {                
        login();
    });   
    
    $('#inputPassword').keydown(function(event) 
    {
        if(event.keyCode == 13)
        {
            event.preventDefault();
            login();
        }
    });
    
    function login() 
    {    
        $('#error').html ("");

        var login = $('#inputLogin').val();
        var password = $('#inputPassword').val();       

        if(login == "")
        {
            console.log("Login error.")
            $('#error').html ("Введите логин");
            return;
        }

        if(password == "")
        {
            console.log("Password error.")
            $('#error').html ("Введите пароль");
            return;
        }

        $.ajax(
        {
            url: "login_data.php",
            type: 'POST',            
            data: 
            {
                login: login, 
                password: password
            },
            dataType: "html",
            success: function (data)
            {       
                if(data == 1)
                {
                    $('#error').html ("Неверный логин");
                    return;
                }  
                else if(data == 2)
                {
                    $('#error').html ("Неверный пароль");
                    return;
                }
                else if(data == 3)
                {
                    $('#error').html ("У Вас отключены cookies.");
                    return;
                }
                else
                {
                    console.log(data);
                    loadMain();
                }
            } 
        });   
    }
});

