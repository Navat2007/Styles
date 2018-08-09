<?php
require './libs/include.php';
require './libs/helper.php'; 

$task_id    = $_POST['task_id'];
$action     = $_POST['action'];
$user       = $_SESSION['logged_user']['ID'];

$task_load_sql    = "SELECT * FROM tasks WHERE ID = '$task_id'";
$task_load_result = mysqli_query($conn, $task_load_sql);
$task_load_row = mysqli_fetch_object($task_load_result);

?>

<div class="back" title="Назад">
    <i id="task_back" class="material-icons">arrow_back</i>
</div>
<div class="card_layout">
    <div class="task_main">
        <!-- Название -->
        <div class="labelfield">
            <i class="material-icons" title="Название">title</i>
            <p>Название</p>
        </div>
        <textarea id="task_add_textArea" rows="3"><?php echo $task_load_row->title; ?></textarea>

        <!-- Описание -->
        <div class="labelfield" id="task_detail_desc_label" style="display: <?php $desc; empty($task_load_row->description) ? $desc = 'none' : $desc = 'flex'; echo $desc; ?>;">
            <i class="material-icons" title="Описание">receipt</i>
            <p>Описание</p>
            <i id="task_detail_desc_close" class="material-icons" title="Удалить">remove</i>
        </div>
        <textarea class="description" id="task_detail_desc" style="display: <?php $desc; empty($task_load_row->description) ? $desc = 'none' : $desc = 'flex'; echo $desc; ?>;" rows="5"><?php echo $task_load_row->description; ?></textarea>

        <!-- Срок -->
        <div class="labelfield" id="task_detail_date_label" style="display: <?php $date; $task_load_row->date == "0000-00-00" ? $date = 'none' : $date = 'flex'; echo $date; ?>;">
            <i class="material-icons" title="Срок">query_builder</i>
            <p>Срок</p>
            <i id="task_detail_date_close" class="material-icons" title="Удалить">remove</i>
        </div>
        <input type="date" id="task_detail_date" style="display: <?php $date; $task_load_row->date == "0000-00-00" ? $date = 'none' : $date = 'flex'; echo $date; ?>;" value="<?php echo $task_load_row->date; ?>">

        <!-- Файлы -->
        <?php    
            $task_files_load_sql    = "SELECT * FROM task_files WHERE taskID = '$task_id'";
            $task_files_load_result = mysqli_query($conn, $task_files_load_sql);

            $task_files_number = mysqli_num_rows($task_files_load_result);    
        ?>    

        <div class="labelfield" id="task_detail_files_label" style="display: <?php $files; $task_files_number == 0 ? $files = 'none' : $files = 'flex'; echo $files; ?>;">
            <i class="material-icons" title="Вложения">attach_file</i>
            <p>Вложения</p>
            <i class="material-icons" title="Удалить">remove</i>
        </div>
        <input type="file" id="task_detail_files" style="display: <?php $files; $task_files_number == 0 ? $files = 'none' : $files = 'flex'; echo $files; ?>;">
        <?php            
            if (mysqli_num_rows($task_files_load_result) > 0) 
            {

            }    
        ?>   

        <!-- Исполнители -->
        <div class="labelfield" id="task_detail_members_label" style="display: <?php $desc; empty($task_load_row->member) ? $desc = 'none' : $desc = 'flex'; echo $desc; ?>;">
            <i class="material-icons" title="Исполнители">person</i>
            <p>Исполнители</p>
            <i class="material-icons" title="Удалить">remove</i>
        </div>

        <!-- Сохранить -->
        <button id="task_detail_save" title="Сохранить">Сохранить</button>
    </div>

    <!-- Кнопки управления -->
    <div class="task_option">
        <div class="task_box">
            <h3>Добавить</h3>
            <button id="task_detail_desc_add_btn" class="task_button_option" title="Добавить описание"><i class="material-icons">receipt</i>Описание</button>
            <button id="task_detail_date_add_btn" class="task_button_option" title="Добавить срок"><i class="material-icons">query_builder</i>Срок</button>
            <button id="task_detail_files_add_btn" class="task_button_option" title="Добавить вложения"><i class="material-icons">attach_file</i>Вложения</button>
            <button id="task_detail__add_btn" class="task_button_option" title="Добавить исполнителя"><i class="material-icons">person</i>Исполнитель</button>
        </div>
        <div class="task_box">
            <h3>Действия</h3>
            <button id="task_detail_archive_btn" class="task_button_option" title="Архивировать"><i class="material-icons">archive</i>Архивировать</button>
        </div>
    </div>
</div>
<script src="js/task_detail.js"></script> 