<?php
require './libs/include.php';

$place               = $_POST['place'];
$action              = $_POST['action'];
$chatID              = $_POST['chatID'];
$user                = $_SESSION['logged_user']['mail'];

if($members_action == "load")
{
    $members_load_sql    = empty($members_search) ? "SELECT ID, login, mail FROM accounts" : "SELECT ID, login, mail FROM accounts WHERE login LIKE '%$members_search%'";
    $members_load_result = mysqli_query($conn, $members_load_sql);
    
    if (mysqli_num_rows($members_load_result) > 0) 
    {
        while ($members_load_row = mysqli_fetch_object($members_load_result)) 
        {
            if($members_list == "all")
            {
                ?>
                    <option value="<?php echo $members_load_row->login; ?>">
                    <?php echo $members_load_row->login; ?></option>
                <?php
            }

            if($members_list == "chouse")            
            {
                $user_config_sql    = "SELECT * FROM usr_theme_config WHERE userID = '$members_load_row->ID' AND themeID = '$members_themeID'";
                $user_config_result = mysqli_query($conn, $user_config_sql);

                if (mysqli_num_rows($user_config_result) > 0) 
                {
                    ?>
                        <option value="<?php echo $members_load_row->login; ?>">
                        <?php echo $members_load_row->login; ?></option>
                    <?php
                }
            }
        }
    }
}

if($members_action == "save")
{
    $members_load_sql    = "SELECT ID, mail FROM accounts WHERE login = '$member'";
    $members_load_result = mysqli_query($conn, $members_load_sql);
    $members_load_row = mysqli_fetch_object($members_load_result);
    
    $user_config_sql    = "SELECT * FROM usr_theme_config WHERE userID = '$members_load_row->ID' AND themeID = '$members_themeID'";
    $user_config_result = mysqli_query($conn, $user_config_sql);
    
    if (mysqli_num_rows($user_config_result) == 0) 
    {  
        $members_save_sql = "INSERT INTO usr_theme_config (userID, themeID) VALUES ('$members_load_row->ID', '$members_themeID')";
        mysqli_query($conn, $members_save_sql);
    }
}

if($members_action == "remove")
{
    $members_load_sql    = "SELECT ID, mail FROM accounts WHERE login = '$member'";
    $members_load_result = mysqli_query($conn, $members_load_sql);
    $members_load_row = mysqli_fetch_object($members_load_result);
    
    $user_config_sql    = "SELECT * FROM usr_theme_config WHERE userID = '$members_load_row->ID' AND themeID = '$members_themeID'";
    $user_config_result = mysqli_query($conn, $user_config_sql);
    
    if (mysqli_num_rows($user_config_result) > 0) 
    {  
        $members_save_sql = "DELETE FROM usr_theme_config WHERE userID = '$members_load_row->ID' AND themeID = '$members_themeID'";
        mysqli_query($conn, $members_save_sql);
    }
}