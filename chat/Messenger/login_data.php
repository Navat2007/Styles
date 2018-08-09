<?php
require './libs/include.php';

$errors = array();
$login = htmlspecialchars($_POST["login"]);
$password = htmlspecialchars($_POST["password"]);
if(strlen($login) > 72) {die("!");}
if(strlen($password) > 72) {die("!");}

if(isset($login))
{
    $sql = "SELECT * FROM accounts WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $row['password']))
        {
            $_SESSION['logged_user'] = $row;              
            
            
            if(empty($_SESSION['logged_user']['ID']))
            {
                $errors[] = '3';
            }
        }
        else 
        {
            $errors[] = '2';
        }               
    } 
    else 
    {
        $errors[] = '1';
    }
}

if(!empty($errors))
{
    echo array_shift($errors);
}