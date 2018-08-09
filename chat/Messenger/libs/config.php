<?php
require 'db_config.php';  
session_start();

$action = $_POST['action'];

// Звук
if($action == 'toggleSound') 
{    
    toogleSound();
}

if($action == 'getSound') 
{    
    getSound();
}

function toogleSound()
{
    $sound = $_POST['sound'];
    
    if($sound == 1)
    {
        $_SESSION['sound'] = 0;  

        getSound();
    }
    else
    {
        $_SESSION['sound'] = 1;   
        
        getSound();
    }
}

function getSound()
{
    if (isset($_SESSION['sound'])) 
    {  
        if($_SESSION['sound'] == 0)
        {        
            echo 'volume_off';    
        }
        else 
        {        
            echo 'volume_mute';
        }
    }
    else 
    {
        $_SESSION['sound'] = 1;
        echo 'volume_mute';
    }    
}


// Ресайз
if($action == 'getResize') 
{    
    getResize();
}

if($action == 'setResize') 
{    
    setResize();
}

function getResize()
{
    if (isset($_SESSION['resize'])) 
    {  
        echo $_SESSION['resize'];  
    }  
}

function setResize()
{
    $_SESSION['resize'] = $_POST['resize'];   
}


// Приватность тем
if($action == 'themePrivate') 
{    
    getPrivate();
}

function getPrivate()
{
    global $conn;
    $themeID = $_POST['themeID'];
    $theme_load_sql    = "SELECT * FROM msg_themes WHERE ID = '$themeID'";
    $theme_load_result = mysqli_query($conn, $theme_load_sql);

    if (mysqli_num_rows($theme_load_result) > 0) {
        $theme_load_row = mysqli_fetch_object($theme_load_result);
        
        if($theme_load_row->private == 1)
        {
            echo '1';
        }
        else {
            echo '0';
        }
    }
}