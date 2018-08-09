var CURRENT_MSG_ID = 0;
var scrollUp = false;
var sounpPlay = false;
var chat_write_status_timer = 0;
var chat_write_timer = 0;
var chat_write = 0;

$(document).ready(function ()
{     
    $('#textarea_send').click(function (event)
    {             
        var text = $('#textarea').val();          
       
        if(text === "")
            return;
        
        if(CURRENT_TASK_ID == 0)
        {
            chatSendMessage(text);
        }
        else
        {
            taskSendMessage(text);
        }
    });  
    
    $('#textarea').keyup(function(event) 
    {                
        if(event.keyCode === 13)
        {   
            event.preventDefault();
            event.stopPropagation();
            
            var text = $('#textarea').val();     
       
            if(text === "")
                return;
            
            if(CURRENT_TASK_ID == 0)
            {                
                chatSendMessage(text);
            }
            else
            {
                taskSendMessage(text);
            }
            
            clearTimeout(chat_write_status_timer);
            clearChatWriteStatus();
        }
        else
        {            
            clearTimeout(chat_write_timer);
            clearTimeout(chat_write_status_timer);
            chat_write_status_timer = setTimeout(function () 
            {           
                clearChatWriteStatus();
            }, 5000);   
            chat_write_timer = setTimeout(function () 
            {           
                chat_write = 0;
            }, 4000); 
            updateChatWriteStatus();
        }
    });  
    
    $('#emojiButton').click(function (event)
    {     
        return;
        
        if(addThemeWindowOpen === 1)
            changeCss(add_themeCss, emptyCss);        
        
        var display = $(".modzy_window").css('display');
        
        if(display === "flex")
        {
            changeCss(add_modzyCss, emptyCss);
            $(".modzy_window").css("display", "none");
        }
        else
        {
            changeCss(emptyCss, add_modzyCss);
            $(".modzy_window").css("display", "flex");
        }
    });     
    
    oldScroll = $('#chat').scrollTop();
});

function loadChat(themeid, msgid, place)
{      
    var chat = $('#chat'); 
    
    if(themeid === 0)
        return;
    
    if(msgid === 0)
    {
        chat.empty();
        scrollUp = true;
    }
    
    $.ajax(
    {
        url: "chat_load.php",
        type: 'POST',            
        data: 
        {
            place: place,
            theme_id: themeid,
            msg_id: msgid
        },
        dataType: "html",
        success: function (data)
        {             
            if(data.length > 2)
            {  
                if(!scrollUp && sound === 1)
                {
                    soundNotify();
                }                
                
                if(chat.scrollTop() + chat.height() === chat.prop('scrollHeight'))
                {
                    scrollUp = true;                    
                }               
                
                chat.append(data);  
                loadTaskNeed();
                loadTaskWork();
                loadTaskDone();                 
                
                if(scrollUp)
                {
                    chat.scrollTop(chat.prop('scrollHeight'));

                    scrollUp = false;
                } 
            }                       
        } 
    });  
}

function chatSendMessage(text, system)
{ 
    clearTimeout(chat_timer);
    
    $('#textarea').val(""); 
    
    if(CURRENT_THEME_ID === 0)
        return;    
    
    var count = $('#chat').children().length;
    
    console.log(text);
    console.log(system);
    
    $.ajax(
    {
        url: "chat_send_message.php",
        type: 'POST',            
        data: 
        {
            action: "chat",
            text: text,
            count: count,
            system: system
        },
        dataType: "html",
        success: function (data)
        {                       
            scrollUp = true;
            loadChat(CURRENT_THEME_ID, CURRENT_MSG_ID, "chat");
            
            chat_timer = setTimeout(function chatLoad() 
            {           
                loadChat(CURRENT_THEME_ID, CURRENT_MSG_ID, "chat");

                chat_timer = setTimeout(chatLoad, 2000);
            }, 2000); 
        } 
    });     
}

function taskSendMessage(text, system)
{ 
    clearTimeout(chat_timer);
    
    $('#textarea').val(""); 
    
    if(CURRENT_TASK_ID === 0)
        return;    
    
    var count = $('#chat').children().length;
    
    $.ajax(
    {
        url: "chat_send_message.php",
        type: 'POST',            
        data: 
        {
            action: "task",
            text: text,
            count: count,
            system: system
        },
        dataType: "html",
        success: function (data)
        {                      
            scrollUp = true;
            loadChat(CURRENT_TASK_ID, CURRENT_MSG_ID, "task");
            
            chat_timer = setTimeout(function taskLoad() 
            {           
                loadChat(CURRENT_TASK_ID, CURRENT_MSG_ID, "task");

                chat_timer = setTimeout(taskLoad, 2000);
            }, 2000); 
        } 
    });     
}

function updateChatWriteStatus()
{
    if(chat_write == 0)
    {
        $.ajax(
        {
            url: "chat_user_write.php",
            type: 'POST',            
            data: 
            {
                action: "write",
                place: CURRENT_TASK_ID == 0 ? "chat" : "task",
                chatID: CURRENT_TASK_ID == 0 ? CURRENT_THEME_ID : CURRENT_TASK_ID
            },
            dataType: "html",
            success: function (data)
            {      
                
                chat_write = 1;
                console.log(CURRENT_USER_NAME +  " печатает сообщение.");
                console.log(chat_write);                               
            } 
        });  
    }
}

function clearChatWriteStatus()
{    
    $.ajax(
    {
        url: "chat_user_write.php",
        type: 'POST',            
        data: 
        {
            action: "delete"
        },
        dataType: "html",
        success: function (data)
        {             
            
            console.log(CURRENT_USER_NAME +  " закончил печатать сообщение.");
        } 
    });  
}

function soundNotify() 
{
    var audio = new Audio(); 
    audio.src = 'audio/notify.mp3'; 
    audio.autoplay = true; 
}

function loadEmoji()
{
    
}
