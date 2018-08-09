<?php
require './libs/include.php';
require './libs/helper.php'; 

$task_id    = $_POST['task_id'];
$action     = $_POST['action'];
$user       = $_SESSION['logged_user']['ID'];

$title    = $_POST['title'];
$desc     = $_POST['desc'];
$date     = $_POST['date'];

if($action == "save")
{
    $update_query = "UPDATE tasks SET title ='$title', description = '$desc', date='$date' WHERE ID = '$task_id'";
    mysqli_query($conn, $update_query);
}

if($action == "archive")
{    
    $update_query = "UPDATE tasks SET archive ='1' WHERE ID = '$task_id'";
    mysqli_query($conn, $update_query);
}