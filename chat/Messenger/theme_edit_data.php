<?php
require './libs/include.php';

$data = $_POST;

$action = $data['action'];  
$title = htmlspecialchars($data['title']);
$theme_id = htmlspecialchars($data['id']);      
    
if($action == "edit")
{
    $update_query = "UPDATE msg_themes SET title = '$title' WHERE ID = '$theme_id'";
    mysqli_query($conn, $update_query);
}

if($action == "delete")
{
    $update_query = "UPDATE msg_themes SET archive = '1' WHERE ID = '$theme_id'";
    mysqli_query($conn, $update_query);
}
