<?php
require './libs/include.php';

$data = $_POST;

$status = htmlspecialchars($data['status']);
$taskID = htmlspecialchars($data['task_id']);

$update_query = "UPDATE tasks SET status = '$status' WHERE ID = '$taskID'";
mysqli_query($conn, $update_query);