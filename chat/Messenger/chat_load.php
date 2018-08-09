<?php
require './libs/include.php';
require './libs/helper.php'; 

$helper = new helper();

$data = $_POST;

$action                    = $data['place'];
$chat_themeId              = $data['theme_id'];
$chat_last_msg_Id          = $data['msg_id'];
$chat_userID               = $_SESSION['logged_user']['ID'];
$_SESSION['chat_theme_id'] = $chat_themeId;

$chat_sql;

if($action == "chat")
{
    $chat_sql    = "SELECT * FROM msg_message WHERE themeid = '$chat_themeId' AND ID > '$chat_last_msg_Id'";
}
else 
{
    $chat_sql    = "SELECT * FROM task_message WHERE taskID = '$chat_themeId' AND ID > '$chat_last_msg_Id'";    
}

$chat_result = mysqli_query($conn, $chat_sql);

if (mysqli_num_rows($chat_result) > 0) 
{
    while ($chat_row = mysqli_fetch_object($chat_result)) 
    {
        $msgID = $chat_row->ID;
        $autor = "";

        $chat_autor_sql    = "SELECT login FROM accounts WHERE ID = '$chat_row->autor'";
        $chat_autor_result = mysqli_query($conn, $chat_autor_sql);
        $chat_autor_row    = mysqli_fetch_object($chat_autor_result);
        
        $final_text = link_it($chat_row->text);

        if($chat_row->autor == 0)
        {
            $autor = "admin_msg";
        }
        else if ($chat_row->autor == $chat_userID) 
        {
            $autor = "self_msg";
        } 
        else 
        {
            $autor = "other_msg";
        }
        ?>
            <div id="msgID_<?php echo $msgID; ?>" class="<?php echo $autor; ?>">
                <div class="box_msg">
                        <?php
                        if ($autor == "other_msg") {
                            echo "<div class=\"text\">";
                            echo "<span class=\"author\">";
                            echo "<i class=\"material-icons\" title=\"Ответить\">reply</i>";
                            echo $chat_autor_row->login;
                            echo "</span><span>";
                            echo $final_text;
                            echo "</span></div>";
                        } 
                        else if($autor == "admin_msg")
                        {
                            echo "<div class=\"admin-icons\">";
                            echo "<i class=\"material-icons\">computer</i>";
                            echo "</div>";
                            echo "<div class=\"admin_text\">";
                            echo $final_text;
                            echo "</div>";
                        } 
                        else 
                        {
                            ?> 
                    <div class="text"><p><?php echo $final_text; ?></p></div>
                            <?php
                        }
                        ?>
                        <div class="date"><span><?php echo $helper->getDateTimeStr($chat_row->date, true); ?></span></div>
                </div>
            </div>
        <?php
                
    }

    $_SESSION['chat_last_msg_id'] = $msgID;
    ?>
    <script>
        CURRENT_MSG_ID = <?php echo $msgID; ?>;
    </script>
    <?php
}

function link_it($text)
{
    $patt = array(
    '%\b(?<!href=[\'"])(?>https?://|www\.)([\p{L}\p{N}]+[\p{L}\p{N}\-]*\.(?:[\p{L}\p{N}\-]+\.)*[\p{L}\p{N}]{2,})(?::\d+)?(?:(?:(?:/[\p{L}\p{N}$_\.\+!\*\'\(\),\%;:@&=-]+)+|/)(?:\?[\p{L}\p{N}$_\.\+!\*\'\(\),\%;:@&=-]+)?(?:#[^\s\<\>]+)?)?(?![^<]*+</a>)%u',
    '%\b(?<!http://)(?<!https://)([\p{L}\p{N}]+[\p{L}\p{N}\-]*\.(?:[\p{L}\p{N}\-]+\.)*(?:ru|com|net|org))(?::\d+)?(?:(?:(?:/[\p{L}\p{N}$_\.\+!\*\'\(\),\%;:@&=-]+)+|/)(?:\?[\p{L}\p{N}$_\.\+!\*\'\(\),\%;:@&=-]+)?(?:#[^\s\<\>]+)?|\b)(?![^<]*+</a>)%u'
    );
    $repl = array(
        '<a href="$0" target=\"_blank\">$1</a>',
        '<a href="http://$0" target=\"_blank\">$1</a>'
    );
    $text = preg_replace($patt, $repl, $text);
    return($text);
}

function makeClickableLinks($text)
{
    $text = html_entity_decode($text);
    $text = " ".$text;
    $text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);  
    $text= preg_replace("/(^|[\n ])([\w]*?)((www|wap)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"$4://$3\" >$3</a>", $text);  
    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);  
    $text= preg_replace("/(^|[\n ])(mailto:[a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"$2@$3\">$2@$3</a>", $text);  
    $text= preg_replace("/(^|[\n ])(skype:[^ \,\"\t\n\r<]*)/i", "$1<a href=\"$2\">$2</a>", $text);  
    return $text;
}

unset($chat_result);
unset($chat_row);


//<div class="reply_msg_self">
//    <div class="reply">
//        <div class = "author">Автор сообщения</div>
//        <div class = "text">Текст сообщения, которое цитируют<p class = "date">16:45</p></div>
//    </div>
//    <div class="reply_author">
//        <i class = "material-icons">reply</i>
//        <div class = "author">Автор сообщения</div>
//        <div class = "text">Текст цитаты<p class = "date">16:10<i class = "material-icons">check</i></p></div>
//    </div>
//</div>

//https://navat2007.amocrm.ru/api/v2/leads?id=858349
//https://navat2007.amocrm.ru/api/v2/notes?element_id=10446543