$(document).ready(function ()
{    
    $('#buttonAddUserCancel').click(function (event)
    {  
        loadLogin(); 
    });
    
    $('#buttonAddUser').click(function (event)
    {                
        event.preventDefault();
        
        var login = $('#addLogin').val();
        var mail = $('#addMail').val();
        var password = $('#addPassword').val();
        var confrimPassword = $('#addConfirmPassword').val();
                
        if(login == "")
        {
            $('#error').text('Введите логин');
            return;
        }
        
        if(checkLogin(login))
        {
            $('#error').text('Логин содержит недопустимые символы.');
            return;
        }
        
        if(mail == "")
        {
            $('#error').text('Введите E-mail');
            return;
        }
        
        if(!checkMail(mail))
        {
            $('#error').text('Email содержит недопустимые символы.');
            return;
        }
        
        if(password == "")
        {
            $('#error').text('Введите пароль');
            return;
        }
        
        if(confrimPassword == "")
        {
            $('#error').text('Подтвердите пароль');
            return;
        }
                
        if(login.length < 3)
        {
            $('#error').text('Логин слишком короткий');
            return;
        }         
        
        if(password.length < 3)
        {
            $('#error').text('Пароль слишком короткий');
            return;
        } 
        
        if(confrimPassword != password)
        {
            $('#error').text('Пароли не совпадают');
            return;
        }
        
        $.ajax(
        {
            url: "add_user_data.php",
            type: 'POST',            
            data: 
            {
                login: login, 
                password: password, 
                mail: mail
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
    if(data == 1)
    {
        $('#error').text('Такой логин уже существует.');
        return;
    }
    
    if(data == 2)
    {
        $('#error').text('Такой E-mail уже существует.');
        return;
    }
    
    $('#error').text("");
    
    console.log("Registaration success, login.");
    loadMain();
}

function checkLogin(login) {
  if (/[^a-zA-Z0-9]/.test(login))
        return true;
  else
        return false;
}

function checkMail(mail) {
    var re = /^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i;
    var valid = re.test(mail);
    
    return valid;
}
