var sound = 1;
var addThemeWindowOpen = 0;

var material_icons = new FontFace('Material Icons', 'url(/MaterialIcons-Regular.woff2)', {
    family: 'Material Icons',
    style: 'normal',
    weight: '400'
});

function loadLogin()
{
    $.ajax(
    {
        url: "login.php",
        type: 'POST',            
        data: 
        {
            
        },
        dataType: "html",
        success: function (data)
        {   
            $('#container').empty();            
            $('#container').append(data);
        }
    });  
}

function loadMain()
{
    $.ajax(
    {
        url: "main.php",
        type: 'POST',            
        data: 
        {
            
        },
        dataType: "html",
        success: function (data)
        {     
            $('#container').empty();               
            $('#container').append(data);
        }
    });  
}