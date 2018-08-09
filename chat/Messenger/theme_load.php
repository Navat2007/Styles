<?php
require './libs/include.php';
require './libs/helper.php'; 

$helper = new helper();

$cur_theme = false;
$cur_theme_id = $_POST['theme_id'];
$search = $_POST['search'];
$user = $_SESSION['logged_user']['ID'];
$theme_load_sql = empty($search) ? "SELECT * FROM msg_themes" : "SELECT * FROM msg_themes WHERE title LIKE '%$search%'";
$theme_load_result = mysqli_query($conn, $theme_load_sql);

if (mysqli_num_rows($theme_load_result) > 0) 
{
    while ($theme_load_row = mysqli_fetch_object($theme_load_result)) 
    {
        $user_config_sql = "SELECT * FROM usr_theme_config WHERE userID = '$user' AND themeID = '$theme_load_row->ID'";
        $user_config_result = mysqli_query($conn, $user_config_sql);
        $user_config_row = mysqli_fetch_object($user_config_result);

        if (mysqli_num_rows($user_config_result) > 0 && $theme_load_row->archive == 0) {

            $user_count_sql = "SELECT * FROM usr_theme_config WHERE themeID = '$theme_load_row->ID'";
            $user_count_result = mysqli_query($conn, $user_count_sql);
            ?>
            <li class="theme_li" 
                data-creator="<?php echo $theme_load_row->autor; ?>" 
                data-id="<?php echo $theme_load_row->ID; ?>" 
                data-title="<?php echo $theme_load_row->title; ?>" 
                data-members="<?php echo mysqli_num_rows($user_count_result); ?>"
                data-date="<?php echo $theme_load_row->date; ?>"
                >
                <div class="main-theme">                      
                    <div class="theme">
                        <div class="theme_name"><?php echo $theme_load_row->title; ?></div>
                        <i id="theme_title_edit" class="material-icons" title="Изменить название">edit</i>
                        <input type="text" class="edit_name" value="">
                        <div class="date"><?php echo $helper->getDateTimeStr($theme_load_row->date); ?></div>
                    </div>
                    <div class="status">
                        <?php 
                        
                        $task_config_sql = "SELECT * FROM tasks WHERE themeID = '$theme_load_row->ID'";
                        $task_config_result = mysqli_query($conn, $task_config_sql);                                               
                        
                        if (mysqli_num_rows($task_config_result) > 0) 
                        {
                            $task_need = 0;
                            $task_work = 0;
                            $task_done = 0;
                            
                            while ($task_config_load_row = mysqli_fetch_object($task_config_result)) 
                            {    
                                if($task_config_load_row->status == "task" && $task_config_load_row->archive != 1)
                                {
                                    $task_need++;
                                }
                                
                                if($task_config_load_row->status == "work" && $task_config_load_row->archive != 1)
                                {
                                    $task_work++;
                                }
                                
                                if($task_config_load_row->status == "done" && $task_config_load_row->archive != 1)
                                {
                                    $task_done++;
                                }   
                            }
                            
                            if($task_need > 0)
                            {
                                ?>                        
                                    <p><?php echo $task_need; ?></p><i class="material-icons" title="Нужно сделать">next_week</i>
                                <?php
                            }
                            
                            if($task_work > 0)
                            {
                                ?>                        
                                    <p><?php echo $task_work; ?></p><i class="material-icons" title="В работе">cached</i>
                                <?php
                            }
                            
                            if($task_done > 0)
                            {
                                ?>                        
                                    <p><?php echo $task_done; ?></p><i class="material-icons" title="Выполнено">done</i>
                                <?php
                            }
                        }
                        ?>                        
                        
                    </div>
                    <!--ВЫЕЗЖАЮЩИЕ КНОПКИ РЕДАКТИРОВАНИЯ ТЕМЫ-->
                <?php
                    if ($theme_load_row->autor == $user) 
                    {
                    ?>
                        <div class="box-option" style="
                            <?php
                            if ($cur_theme_id == $theme_load_row->ID) 
                            {
                                echo "left: 0.8em;";
                            }
                            ?>
                        ">
                            <i class="material-icons" id="theme_archive_button" title="В архив">delete</i>
                            <i class="material-icons" id="theme_members_button" title="Участники">person_add</i>
                        </div>
                        <?php
                    } 
                    else 
                    {
                        ?>
                        <div class="box-option" style="
                            <?php
                            if ($cur_theme_id == $theme_load_row->ID) {
                                echo "left: 0.8em;";
                            }
                            ?>
                        ">
                            <i class="material-icons" id="theme_exit_button" title="Выйти">close</i>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <!--АКТИВЕН ПРИ ВЫБРАННОЙ ТЕМЕ-->
                <div class="<?php
            if ($cur_theme_id == $theme_load_row->ID)
                echo "box-on";
            else
                echo "box";
                    ?>"></div>                
            </li>  
            <?php
        }
    }
}