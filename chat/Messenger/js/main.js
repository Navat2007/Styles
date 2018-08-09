var CURRENT_USER_ID = 0;
var CURRENT_USER_NAME = "";
var CURRENT_THEME_ID = 0;
var CURRENT_THEME_AUTOR = 0;
var CURRENT_THEME_NAME = "";
var CURRENT_THEME_ELEMENT = null;
var CURRENT_TASK_ID = 0;
var CURRENT_TASK_NAME = "";
var task_add_Window = false;
var chat_timer;



$(document).ready(function ()
{     
    document.fonts.add(material_icons);
    material_icons.load();
    
    // Загрузка настроек звука
    getSound();    
    
    // Загрузка пустой страницы в окно чата
    $('#chat').load("blank.php");      
    
    // Клик по "+" в открытом левом меню
    $('#add_theme_button').click(function (event)
    {  
        $('#modal_window').load("theme_add.php");  
        addThemeWindowOpen = 1;
        $( ".modal" ).css("display", "flex");
        //$( ".modal" ).fadeIn();
    });
    
    // УВЕДОМЛЕНИЯ" в правом верхнем углу
    $('#notification_check').click(function (event)
    {  
        var display = $(".notification_window").css('display');        
        if(display === "none")
        {
            $( ".notification_window" ).fadeIn();
        }
        else
        {
            $( ".notification_window" ).fadeOut();
        }
    }); 
    
    // ВЫХОД в правом верхнем углу
    $('#exit').click(function (event)
    {  
        $('#container').load("logout.php");   
    });     
    
    // МЕНЮ(гамбургеру) в левом верхнем углу
    $('#leftMenu').click(function (event)
    {  
        loadThemes();
        leftMenuShow();
    });
    
    // ТЕМА и кнопкам внутри карточки темы
    $('#theme_list').on('click','.theme_li', function (event)
    {          
        CURRENT_THEME_ELEMENT = $(this);            
        
        var theme_name = CURRENT_THEME_ELEMENT.find('.theme_name');
        var theme_title_edit_btn = CURRENT_THEME_ELEMENT.find('#theme_title_edit');
        var theme_name_input = CURRENT_THEME_ELEMENT.find('.edit_name');
        var theme_members_btn = CURRENT_THEME_ELEMENT.find('#theme_members_button');
        var theme_archive_btn = CURRENT_THEME_ELEMENT.find('#theme_archive_button');
        
        // Если клик был по кнопке редактировать
        if (theme_title_edit_btn.is(event.target)) 
        {             
            themeClick();
            
            theme_name.css('display', 'none');
            theme_name_input.val(CURRENT_THEME_NAME);
            theme_name_input.css('display', 'block');
            theme_name_input.focus();
        }
        // Клик по input
        else if(theme_name_input.is(event.target))
        {
            event.stopPropagation();
        } 
        // Клик по кнопке пользователи
        else if(theme_members_btn.is(event.target))
        {
            themeMembersClick(); 
        } 
        // Клик по кнопке архив
        else if(theme_archive_btn.is(event.target))
        {
            themeClick();
            
            swal({
                title: 'Вы уверены что хотите оправить в архив?',
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
                        url: "theme_edit_data.php",
                        type: 'POST',            
                        data: 
                        {
                            action: "delete",
                            title: "",
                            id: CURRENT_THEME_ID
                        },
                        dataType: "html",
                        success: function (data)
                        {       
                            swal({
                                type: 'success',
                                title: 'Тема ' + CURRENT_THEME_NAME + ' в архиве.',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            CURRENT_THEME_ID = 0;
                            CURRENT_THEME_AUTOR = 0;
                            CURRENT_THEME_NAME = "";
                            $('#chat').load("blank.php"); 
                            loadThemes("", true);
                        }
                    }); 
                }
            });
        } 
        else
        {
            themeClick();
        }
    });    
    
    // Клик по кол-ву учасников в верхней полоске
    $('.status_members').click(function (event)
    {  
        themeMembersClick();
    });
    
    // Клик по фону когда открыто левое боковое меню
    $('.fon').click(function (event)
    {  
        leftMenuShow();
    }); 
    
    // Клик по кнопке "+" в колонке "Нужно сделать"
    $('#addTask').click(function (event)
    {  
        if(CURRENT_THEME_ID === 0)
            return;
        
        if(!task_add_Window)
        { 
            $('#container_need_to_do').append('<li id="new_task_window"></li>');              
            
            $.ajax(
            {
                url: "task_add.php",
                type: 'POST',            
                data: 
                {
                },
                dataType: "html",
                success: function (data)
                {       
                    $('#new_task_window').append(data); 
                    task_add_Window = true;
                    $('.col_need_to_do').scrollTop($('.col_need_to_do').prop('scrollHeight'));
                } 
            });              
        }
    });  
    
    // Клик по всему документу
    $(document).mouseup(function (e)
    {    
        // Для тестирования
        //console.log(e.target);
        
        // Проверка на клик вне input редактирования названия темы
        if(CURRENT_THEME_ELEMENT !== null)
        {            
            var div = $(".edit_name");
            if (!div.is(e.target)) 
            { 
                CURRENT_THEME_ELEMENT.find('.theme_name').css('display', 'block');
                CURRENT_THEME_ELEMENT.find('.edit_name').val("");
                CURRENT_THEME_ELEMENT.find('.edit_name').css('display', 'none');
            }  
        }            
        
        // Проверка на клик вне временной карточки добавления задания
        var div = $(".new_task");
        
        if (!div.is(e.target) && div.has(e.target).length === 0) 
        { 
            div.remove(); 
            $('#container_need_to_do').find('#new_task_window').remove();
            task_add_Window = false;
        }        
    });   
    
    // Нажатие кнопок по всему документу
    $(document).keyup(function (e)
    {    
        // Для тестирования
        //console.log(e.keyCode);           
        
        if(CURRENT_THEME_ELEMENT !== null)
        {
            // Редактирование названия темы
            if(CURRENT_THEME_ELEMENT.find('.edit_name').css('display') === 'block')
            {
                switch( event.keyCode ) 
                {                
                    case 13:
                        event.preventDefault();
                        themeNameSave();
                        break;
                    case 27:
                        CURRENT_THEME_ELEMENT.find('.theme_name').css('display', 'block');
                        CURRENT_THEME_ELEMENT.find('.edit_name').val("");
                        CURRENT_THEME_ELEMENT.find('.edit_name').css('display', 'none');
                        break;
                }
            }
        }
    });  
    
    chat_timer = setTimeout(function chatLoad() 
    {           
        loadChat(CURRENT_THEME_ID, CURRENT_MSG_ID, "chat");
        
        chat_timer = setTimeout(chatLoad, 2000);
    }, 2000); 
});

function themeClick()
{    
    CURRENT_THEME_ID = CURRENT_THEME_ELEMENT.attr('data-id');
    CURRENT_THEME_NAME = CURRENT_THEME_ELEMENT.attr('data-title');
    CURRENT_THEME_AUTOR = CURRENT_THEME_ELEMENT.attr('data-creator');
    CURRENT_MSG_ID = 0;
    leftMenuChouse(CURRENT_THEME_ELEMENT);  
    statusChange(CURRENT_THEME_NAME, 'Участников: ' + CURRENT_THEME_ELEMENT.attr('data-members'));      
    
    closeTask();
}

function themeMembersClick()
{    
    $.ajax(
    {
        url: "theme_members.php",
        type: 'POST',            
        data: 
        {
            theme_autor: CURRENT_THEME_AUTOR
        },
        dataType: "html",
        success: function (data)
        {       
            $('#modal-2_window').append(data);
            addThemeWindowOpen = 1;
            $(".modal-2").css("display", "flex");          
        } 
    });        
}

function themeTitleClick()
{
    
}

function themeNameSave()
{
    var theme_name = CURRENT_THEME_ELEMENT.find('.edit_name').val();

    if(theme_name == CURRENT_THEME_NAME)
    {     
        loadThemes();
        return;
    }

    if(theme_name == "")
    {        
        return;
    }

    $.ajax(
    {
        url: "theme_edit_data.php",
        type: 'POST',            
        data: 
        {
            action: "edit",
            title: theme_name,
            id: CURRENT_THEME_ID
        },
        dataType: "html",
        success: function (data)
        {       
            loadThemes("", true);
        }
    });  
}

function loadThemes(data, click)
{        
    $.ajax(
    {
        url: "theme_load.php",
        type: 'POST',            
        data: 
        {
            theme_id: CURRENT_THEME_ID,
            search: data   
        },
        dataType: "html",
        success: function (data)
        {               
            $("#theme_list").empty();
            $("#theme_list").append(data);
            
            if(click)
            {
                $('li[data-id|="' + CURRENT_THEME_ID + '"]').click();
            }
        } 
    });  
}

function loadTaskNeed(data)
{        
    $.ajax(
    {
        url: "task_load.php",
        type: 'POST',            
        data: 
        {
            action: "task",
            theme_id: CURRENT_THEME_ID   
        },
        dataType: "html",
        success: function (data)
        {       
            $("#container_need_to_do").empty();
            $("#container_need_to_do").append(data);
        } 
    });  
}

function loadTaskWork(data)
{        
    $.ajax(
    {
        url: "task_load.php",
        type: 'POST',            
        data: 
        {
            action: "work",
            theme_id: CURRENT_THEME_ID   
        },
        dataType: "html",
        success: function (data)
        {       
            $("#container_in_work").empty();
            $("#container_in_work").append(data);
        } 
    });  
}

function loadTaskDone(data)
{        
    $.ajax(
    {
        url: "task_load.php",
        type: 'POST',            
        data: 
        {
            action: "done",
            theme_id: CURRENT_THEME_ID   
        },
        dataType: "html",
        success: function (data)
        {       
            $("#container_done").empty();
            $("#container_done").append(data);
        } 
    });  
}

function openTask(data)
{       
    clearTimeout(chat_timer);
    
    $(".card").css('display', 'flex');
    $(".col_need_to_do").css('display', 'none');
    $(".col_in_work").css('display', 'none');
    $(".col_done").css('display', 'none');
    
    $.ajax(
    {
        url: "task_detail_data.php",
        type: 'POST',            
        data: 
        {
            action: "load",
            task_id: CURRENT_TASK_ID   
        },
        dataType: "html",
        success: function (data)
        {       
            $(".card").empty();
            $(".card").append(data);
            
            CURRENT_MSG_ID = 0;
            
            loadChat(CURRENT_TASK_ID, CURRENT_MSG_ID, "task");
            chat_timer = setTimeout(function taskLoad() 
            {           
                loadChat(CURRENT_TASK_ID, CURRENT_MSG_ID, "task");

                chat_timer = setTimeout(taskLoad, 2000);
            }, 2000); 
        } 
    });  
    
}

function closeTask(data)
{   
    clearTimeout(chat_timer);
    CURRENT_TASK_ID = 0;
    CURRENT_MSG_ID = 0;
    
    $(".card").css('display', 'none');
    $(".col_need_to_do").css('display', 'block');
    $(".col_in_work").css('display', 'block');
    $(".col_done").css('display', 'block');    
    
    loadChat(CURRENT_THEME_ID, CURRENT_MSG_ID, "chat");
        
    chat_timer = setTimeout(function chatLoad() 
    {           
        loadChat(CURRENT_THEME_ID, CURRENT_MSG_ID, "chat");

        chat_timer = setTimeout(chatLoad, 2000);
    }, 2000); 
    
    loadTaskNeed();
    loadTaskWork();
    loadTaskDone();    
}

function toggleSound()
{
    $.ajax({
        type: "POST",
        url: 'libs/config.php',
        data: 
        {
            action: 'toggleSound',
            sound: sound
        },
        success:function(html) 
        {
            $("#toggleSound").html(html); 
            getSound();            
        }
    });
}

function getSound()
{
    $.ajax({
        type: "POST",
        url: 'libs/config.php',
        data: 
        {
            action: 'getSound'
        },
        success:function(html) 
        {
            if(html == 'volume_mute')
                sound = 1;
            
            if(html == 'volume_off')
                sound = 0;
        }
    });
}

function leftMenuShow()
{    
    var display = $(".fon").css('display');        
    if(display === "block")    
    {        
        $(".left").css("left", "-20em");        
        $( ".fon" ).fadeOut();    
    }    
    else    
    {        
        $(".left").css("left", "0");        
        $( ".fon" ).fadeIn();    
    }
}

function leftMenuChouse(target)
{    
    $('.box-on').attr('class','box');
    $('.box-option').css('left', '-10em');
    
    var box = target.children(".box");
    var boxopt = target.children().children(".box-option");
    box.attr('class','box-on');    
    boxopt.css('left', '0.8em');
}

function statusChange(title, members)
{
    $(".status_name").text(title);
    $(".status_members").text(members);
}


// Drag and Drop
var dragObject = null;
function drag_enter(event)
{
    event.preventDefault();
    
    var target = event.target.closest('.dropZone');
    
    if(target != null)
    {
        //console.log('Вход в зону dragZone: ' + target.getAttribute('class') + ' ' + target.getAttribute('id'));
    }
}

function drag_leave(event)
{
    event.preventDefault();
    
    var target = event.target.closest('.dropZone');
    
    if(target != null)
    {
        //console.log('Выход из зоны dragZone: ' + target.getAttribute('class') + ' ' + target.getAttribute('id'));
    }
}

function drag_start(event)
{
    dragObject = event.target; 
}

function drag_drop(event)
{
    event.preventDefault();   
    var obj_id = dragObject.getAttribute('data-id');    
    var obj_name = dragObject.getAttribute('data-task-name');    
    var obj_status = dragObject.getAttribute('data-status');    
    var target = event.target.closest('.dropZone');   
    var objContID = target.getAttribute('id');       
    
    var status;
    var statusChatMsg;
    
    if(objContID == "container_need_to_do")
    {
        status = "task";
        statusChatMsg = "Нужно сделать";
    }
    
    if(objContID == "container_in_work")
    {
        status = "work";
        statusChatMsg = "В работе";
    }
    
    if(objContID == "container_done")
    {
        status = "done";
        statusChatMsg = "Выполнено";
    }
    
    if(status == obj_status)
        return;
    
    target.append(dragObject);
    chatSendMessage("<span><b>" + CURRENT_USER_NAME + "</b> переместил задачу &laquo;" + obj_name + "&raquo; <b>&rArr; " + statusChatMsg + "</b></span>", 1);
    
    $.ajax(
    {
        url: "task_save.php",
        type: 'POST',            
        data: 
        {
            action: "save",
            status: status,
            task_id: obj_id   
        },
        dataType: "html",
        success: function (data)
        {       
            loadTaskNeed();
            loadTaskWork();
            loadTaskDone(); 
        } 
    });      
}

function drag_end(event) 
{
    dragObject = null;
}