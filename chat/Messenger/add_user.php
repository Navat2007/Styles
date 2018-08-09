<?php
require './libs/include.php';
?>

<script src="js/add_user.js"></script>

<!--Регистрация-->
<div class="login">
    <form class="form_login">
        <h1>Регистрация</h1>
        <div class="textfield">
            <input type="text" name="login" id="addLogin" autocomplete="name" autofocus="" required>
            <span class="bar"></span>
            <label for="addLogin">Логин</label>
        </div>
        <div class="textfield">
            <input type="email" name="email" id="addMail" autocomplete="on" required>
            <span class="bar"></span>
            <label for="addMail">E-mail</label>
        </div>
        <div class="textfield">
            <input type="password" name="password" id="addPassword" autocomplete="password" required>
            <span class="bar"></span>
            <label for="addPassword">Пароль</label>
        </div>
        <div class="textfield">
            <input type="password" id="addConfirmPassword" autocomplete="off" required>
            <span class="bar"></span>
            <label for="addConfirmPassword">Подтвердите пароль</label>
        </div>
        <span id="error"></span>
        <div class="textfield">
            <span>Уже зарегистрированы?</span><a id="buttonAddUserCancel">Войти</a>
        </div>
            <button type="button" id="buttonAddUser">Создать</button>
    </form>
</div>