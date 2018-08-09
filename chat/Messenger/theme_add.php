<?php
require './libs/include.php';
?>

<script src="js/theme_add.js"></script>

<!--Добавление темы-->               
<div class="theme_form">
    <i id="add_theme_button_close" class="material-icons error">close</i>
    <div class="textfield">
        <input type="text" id="theme_add_name" required>
        <span class="bar"></span>
        <label>Название темы</label>
    </div>
    <span id="error"></span>
    <button id="add_theme_button_create" type="button">Создать</button>
</div>