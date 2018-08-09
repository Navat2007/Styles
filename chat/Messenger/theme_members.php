<?php
require './libs/include.php';

$member_theme_id = $_POST['theme_autor'];
$member_user = $_SESSION['logged_user']['ID'];
?>

<script src="js/theme_members.js"></script>

<!--Редактирование темы "edit"-->
<div class="theme_form">
    <i id="theme_members_button_close" class="material-icons error">close</i>
    <h1>Участники</h1>    
    <div class="list-users">
        <?php
        if ($member_theme_id == $member_user) {
            ?>     
            <div id="theme_members_left_list" class="list">
                <div class="textfield">
                    <input type="text" id="theme_members_input_all" required>
                    <span class="bar"></span>
                    <label>Введите имя...</label>
                </div>
                <select id="theme_members_select_all" class="list-value" multiple>
                    
                </select>
            </div>
            <div id="theme_members_central_tab" class="tabs">
                <i id="theme_members_button_add" class="material-icons">chevron_right</i>
                <i id="theme_members_button_remove" class="material-icons">chevron_left</i>
            </div>
            <div id="theme_members_right_list" class="list">
                <div class="textfield">
                    <input type="text" id="theme_members_input_chouse" required>
                    <span class="bar"></span>
                    <label>Введите имя...</label>
                </div>
                <select id="theme_members_select_chouse" class="list-value" multiple>

                </select>
            </div>
            <?php
        } else {
            ?> 
            <div id="theme_members_right_list" class="list">
                <div class="textfield">
                    <input type="text" id="theme_members_input_chouse" required>
                    <span class="bar"></span>
                    <label>Введите имя...</label>
                </div>
                <select id="theme_members_select_chouse" class="list-value" multiple>

                </select>
            </div>
            <?php
        }
        ?>
    </div>
    <span id="error"></span>
    <!--<button id="theme_members_confirm_button" type="button">Изменить</button>-->
</div>