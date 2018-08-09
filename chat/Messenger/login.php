<?php
require './libs/include.php';
?>

<!--Авторизация-->
<script src="js/login.js"></script>
<div class="login">
    <form class="form_login">
        <h1>Окно входа</h1>
        <div class="textfield">
            <input type="text" name="login" id="inputLogin" autocomplete="name" autofocus="" required>
            <span class="bar"></span>
            <label for="inputLogin">Логин</label>
        </div>
        <div class="textfield">
            <input type="password" name="password" id="inputPassword" autocomplete="password" required>
            <span class="bar"></span>
            <label for="inputPassword">Пароль</label>
        </div>
        <span id="error"></span>
        <div class="textfield">
            <a>Забыли пароль?</a>|<a id="buttonRegistration">Регистрация</a>
        </div>
        <button type="button" id="buttonLogin">Войти</button>
    </form>
</div>




