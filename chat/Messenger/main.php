<?php
require './libs/include.php';
require './libs/config.php';
require './libs/helper.php';

$helper = new helper();

$CURRENT_THEME_ID;

init_load();

function init_load()
{   // Настройки ресайза
    if (isset($_SESSION['resize'])) 
    { 
        
    }
    else 
    {
        
    }
}

require './main_html.php';

?>
<script> 
    CURRENT_USER_ID = <?php echo $_SESSION['logged_user']['ID']; ?>;
    CURRENT_USER_NAME = '<?php echo $_SESSION['logged_user']['login']; ?>';
</script>
<?php



