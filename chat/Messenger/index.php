<?php
require './libs/include.php';
header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Messenger</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <script src="js/jquery-3.3.1.min.js"></script>      
        <script src="js/sweetalert2.all.js"></script>      
        <script src="js/index.js"></script>             
        <link rel="stylesheet" href="css/fonts.css">    
        <link rel="stylesheet" href="css/login.css">    
        <link rel="stylesheet" href="css/main.css">    
        <link rel="stylesheet" href="css/addTheme.css">    
        <link rel="stylesheet" href="css/centerRight.css">    
    </head>
    <body>        
        <div id="container">
            <?php
            if (isset($_SESSION['logged_user'])) 
            {
                $user_login = $_SESSION['logged_user']['login'];
                $sql_login = "SELECT * FROM accounts WHERE login = '$user_login'";
                $result_login = mysqli_query($conn, $sql_login);

                if (mysqli_num_rows($result_login) == 0) 
                {
                    session_destroy();
                    showLogin();
                } 
                else 
                {
                    ?>
                    <script>
                        loadMain();
                    </script>
                    <?php
                }
            } 
            else 
            {
                showLogin();
            }

            function showLogin() 
            {
                ?>
                <script>
                    loadLogin();
                </script>
                <?php
            }
            ?>
        </div>
    </body>
</html>