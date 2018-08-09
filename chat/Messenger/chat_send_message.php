<?php
require './libs/include.php';

$data = $_POST;

$action = htmlspecialchars($data['action']);
$text = $data['text'];
$count = htmlspecialchars($data['count']);
$system = htmlspecialchars($data['system']);
$autor = $_SESSION['logged_user']['ID'];
$theme_id = $_SESSION['chat_theme_id'];  
    
$count++;

if($system == 1)
{
    $autor = 0;
}

if($action == "chat")
{
    $b = false;
    $chat_sql = "SELECT * FROM msg_message WHERE themeid = '$theme_id' AND autor = '$autor' ORDER BY ID DESC LIMIT 1";
    $chat_result = mysqli_query($conn, $chat_sql);

    if (mysqli_num_rows($chat_result) > 0) 
    {
        $chat_row = mysqli_fetch_object($chat_result);
        if($chat_row->text == $text)
        {
            $b = true;
        }
    }
    
    if(!$b)
    {
        $insert_query = "INSERT INTO msg_message (themeid, autor, text) VALUES ('$theme_id', '$autor', '$text')";
        $update_query = "UPDATE msg_themes SET lastMessage = '$text', count = '$count' WHERE ID = '$theme_id'";

        if(!empty($text))
        {
            mysqli_query($conn, $insert_query);
            mysqli_query($conn, $update_query);
        }
    }
}

if($action == "task")
{
    $b = false;
    $chat_sql = "SELECT * FROM task_message WHERE taskID = '$theme_id' AND autor = '$autor' ORDER BY ID DESC LIMIT 1";   
    $chat_result = mysqli_query($conn, $chat_sql);

    if (mysqli_num_rows($chat_result) > 0) 
    {
        $chat_row = mysqli_fetch_object($chat_result);
        if($chat_row->text == $text)
        {
            $b = true;
        }
    }
    
    if(!$b)
    {
        $insert_query = "INSERT INTO task_message (taskID, autor, text) VALUES ('$theme_id', '$autor', '$text')";

        if(!empty($text))
        {
            mysqli_query($conn, $insert_query);
        }
    }
}