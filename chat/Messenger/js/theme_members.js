$(document).ready(function ()
{
    var change = false;
    
    var close = $('#theme_members_button_close');
    var searchAll = $('#theme_members_input_all');
    var searchChouse = $('#theme_members_input_chouse');    
    var allList = $('#theme_members_select_all');
    var chouseList = $('#theme_members_select_chouse');
    var addBtn = $('#theme_members_button_add');
    var removeBtn = $('#theme_members_button_remove');     
    
    LoadMembers("", "all");
    LoadMembers("", "chouse");
    
    // Клик по кнопке закрытия формы
    close.click(function (event)
    {  
        Close(change);
    });     
    
    // Клик по кнопке ">"
    addBtn.click(function (event)
    {  
        var msvAll = new Array();
        msvAll = allList.val();
        
        $.each(msvAll,function(index,value)
        {          
            SaveMembers(value);
            change = true;
        });
        
        LoadMembers(searchChouse.val(), "chouse");
    });
    
    // Клик по кнопке "<"
    removeBtn.click(function (event)
    {  
        var msvAll = new Array();
        msvAll = chouseList.val();
        
        $.each(msvAll,function(index,value)
        {     
            if(value != CURRENT_USER_NAME)
            {              
                RemoveMembers(value);
                console.log(CURRENT_USER_NAME);
                console.log("Удаляю: " + value + " из темы: " + CURRENT_THEME_NAME);
                change = true;
            }
        });
        
        LoadMembers(searchChouse.val(), "chouse");
    });
    
    searchAll.keydown(function (e)
    {    
        if(e.keyCode === 13)
        {
            e.preventDefault();
        }        
    });  
    
    searchAll.keyup(function (e)
    {    
        if(e.keyCode === 13)
        {
            e.preventDefault();
        } 
        
        LoadMembers(searchAll.val(), "all");
    });  
    
    searchChouse.keydown(function (e)
    {    
        if(e.keyCode === 13)
        {
            e.preventDefault();
        }        
    });  
    
    searchChouse.keyup(function (e)
    {    
        if(e.keyCode === 13)
        {
            e.preventDefault();
        } 
        
        LoadMembers(searchChouse.val(), "chouse");
    });  
    
    function SaveMembers(user)
    {
        $.ajax(
        {
            url: "theme_members_data.php",
            type: 'POST',            
            data: 
            {
                action: "save",
                user: user,
                themeID: CURRENT_THEME_ID
            },
            dataType: "html",
            success: function (data)
            {
                
            }
        });  
    }
    
    function RemoveMembers(user)
    {
        $.ajax(
        {
            url: "theme_members_data.php",
            type: 'POST',            
            data: 
            {
                action: "remove",
                user: user,
                themeID: CURRENT_THEME_ID
            },
            dataType: "html",
            success: function (data)
            {
                
            }
        });  
    }
    
    function LoadMembers(search, list)
    {
        $.ajax(
        {
            url: "theme_members_data.php",
            type: 'POST',            
            data: 
            {
                action: "load",
                list: list,
                search: search,
                themeID: CURRENT_THEME_ID
            },
            dataType: "html",
            success: function (data)
            {
                if(list === "all")
                {
                    allList.empty();
                    allList.append(data);
                }
                
                if(list === "chouse")
                {
                    chouseList.empty();
                    chouseList.append(data);
                }
            }
        });  
    }
    
    function Close(bool)
    {
        $('#modal-2_window').load("blank.php"); 
        
        addThemeWindowOpen = 0;
        $(".modal-2").css("display", "none");
        
        loadThemes("", bool);
    }
});







