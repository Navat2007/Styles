$(document).ready(function ()
{       
    getResize();
    
    var windowWidth = $(window).width(); //retrieve current window width
    var windowHeight = $(window).height(); //retrieve current window height

    setInterval(function() {
        windowWidth = $(window).width(); //retrieve current window width
        windowHeight = $(window).height(); //retrieve current window height
    }, 100);  
           
    var div = $(".textarea");
    var left = $(".task_window");
    var right = $(".chat");
    var resize = $("#resize");
    
    var unlock = false;
    var chat = $('#chat'); 
    var chat_scroll = chat.scrollTop();
    var chat_size = chat.prop('scrollHeight');
    
    $(document).mousemove(function(e) 
    {
        var proc = e.clientX * (100/windowWidth);	
                
        if(unlock) 
        {
            if(proc > 50) 
            {      
                if(proc < 80)
                {
                    left.css("width", proc + "%");
                    right.css("width", (100 - proc) + "%");
                }
            }
            else 
            {
                left.css("width", "49.7%");
                right.css("width", "50%");
            }
            
            chat.scrollTop(chat_scroll + chat.height() + (chat.prop('scrollHeight') - chat_size));
        }        
    });
    
    resize.mousedown(function(e) {
        unlock = true;
        chat_scroll = chat.scrollTop();
        chat_size = chat.prop('scrollHeight');
    });
    
    $(document).mousedown(function(e) {
        if(unlock) {
          e.preventDefault();
        }        
    });
    
    $(document).mouseup(function(e) {
        unlock = false;
        var proc = left.width() * (100/windowWidth);
        setResize(proc);
    });
});

function getResize()
{
    $.ajax({
        type: "POST",
        url: 'libs/config.php',
        data: 
        {
            action: 'getResize'
        },
        success:function(html) 
        {
            if(html.length == 1 || html.length == 0)
                html = 70;
            
            $(".task_window").css("width", html + '%');
            $(".chat").css("width", (100 - html - 0.3) + '%');
        }
    });
}

function setResize(data)
{
    $.ajax({
        type: "POST",
        url: 'libs/config.php',
        data: 
        {
            action: 'setResize',
            resize: data
        },
        success:function(html) 
        {}
    });
}

