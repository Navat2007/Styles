<?php
require './libs/include.php';
require './libs/rb.php';    
R::setup( 'mysql:host=localhost;dbname=id82372760', 'id82372760', 'EVEonline2007' ); 

$errors = array();
$data = $_POST;

if(R::count('accounts', "login = ?", array($data['login'])) > 0)
{
    $errors[] = "1";
}

if(R::count('accounts', "mail = ?", array($data['mail'])) > 0)
{
    $errors[] = "2";
}

if(empty($errors))
{
    $account = R::dispense('accounts');
    $account->login = $data['login'];
    $account->mail = $data['mail'];
    $account->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $account->phone = '';
    $account->active = 'y';
    $account->role = 'user';
    
    R::store($account); 
    
    $login = $data['login'];
    $sql = "SELECT * FROM accounts WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['logged_user'] = $row;
    
    mkdir("./accs/$login",0777);
    mkdir("./accs/$login/avatar",0777);
    mkdir("./accs/$login/upload",0777);
}
else 
{
    echo array_shift($errors);
}