<?php
require './libs/include.php';
require './libs/helper.php'; 

$helper = new helper();

$theme_id   = $_POST['theme_id'];
$action     = $_POST['action'];
$user       = $_SESSION['logged_user']['ID'];

$task_load_sql    = "SELECT * FROM tasks WHERE themeID = '$theme_id' AND status = '$action'";
$task_load_result = mysqli_query($conn, $task_load_sql);

if (mysqli_num_rows($task_load_result) > 0) 
{
    while ($task_load_row = mysqli_fetch_object($task_load_result)) 
    {
        if($task_load_row->archive != 1)
        {
            ?>
                <li onclick="CURRENT_TASK_ID= <?php echo $task_load_row->ID; ?>; openTask();" data-id="<?php echo $task_load_row->ID; ?>" data-task-name="<?php echo $task_load_row->title; ?>" data-status="<?php echo $task_load_row->status; ?>" draggable="true" ondragstart="drag_start(event)" ondragend="drag_end(event)">
                    <div class="task_node">
                        <h3><?php echo $task_load_row->title; ?></h3>
                        <p><?php echo $task_load_row->description; ?></p>
                        <div class="notification">
                            <?php if($task_load_row->date != "0000-00-00"){ ?><i class="material-icons">schedule</i><p class="date"><?php echo $helper->getDateStr($task_load_row->date); ?></p><?php } ?>
                            <?php if(!empty($task_load_row->files)){ ?><i class="material-icons">attach_file</i><p class="date"><?php echo $task_load_row->files; ?></p><?php } ?>
                            <?php 
                                $task_msg_load_sql    = "SELECT * FROM task_message WHERE taskID = '$task_load_row->ID'";
                                $task_msg_load_result = mysqli_query($conn, $task_msg_load_sql);

                                if(mysqli_num_rows($task_msg_load_result) > 0)
                                { 
                                    ?>
                                        <i class="material-icons">mode_comment</i><p class="date"><?php echo mysqli_num_rows($task_msg_load_result); ?></p>
                                    <?php                                     
                                } 
                            ?>                            
                        </div>
                    </div>
                </li>
            <?php
        }
    }
}