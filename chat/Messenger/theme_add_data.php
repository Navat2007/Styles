<?php
require './libs/include.php';

$data = $_POST;

$title = $data['title'];
$autor = $_SESSION['logged_user']['ID'];

// Добавляем новую тему
$query = "INSERT INTO msg_themes (title, autor) VALUES ('$title', '$autor')";
mysqli_query($conn, $query);

// Добавляем пользователя который создал тему
$queryMax = "SELECT * FROM msg_themes WHERE title = '$title' AND autor = '$autor'";
$result = mysqli_query($conn, $queryMax);
$row = mysqli_fetch_object($result);
$id = $row->ID;

$query2 = "INSERT INTO usr_theme_config (userID, themeID) VALUES ('$autor', '$id')";
mysqli_query($conn, $query2);





