<?php
require './libs/include.php';

$data = $_POST;

$title = $data['title'];
$themeID = $data['themeID'];
$autor = $_SESSION['logged_user']['ID'];

// Добавляем новую задачу
$query = "INSERT INTO tasks (title, themeID, autorID) VALUES ('$title', '$themeID', '$autor')";
mysqli_query($conn, $query);

// Добавляем пользователя который создал тему
/*
$queryMax = "SELECT * FROM msg_themes WHERE title = '$title' AND autor = '$autor'";
$result = mysqli_query($conn, $queryMax);
$row = mysqli_fetch_object($result);
$id = $row->ID;

$query2 = "INSERT INTO usr_theme_config (userID, themeID) VALUES ('$autor', '$id')";
mysqli_query($conn, $query2);
*/




