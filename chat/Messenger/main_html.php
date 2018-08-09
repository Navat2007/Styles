<script src="js/main.js"></script>
<script src="js/chat.js"></script>
<script src="js/resize.js"></script> 

<div class="main">
    <div class="fon"><!--Затемнение экрана при выезжании окна display: block;--></div>
    <div class="left">
        <!-- Боковое меню -->
        <div class="top_menu">
            <input id="search" type="text" name="search" placeholder="Найти..." onkeyup="loadThemes(this.value);">
            <i id="add_theme_button" class="material-icons active_left_menu" title="Добавить">add</i>
        </div>

        <!-- Список тем -->
        <ul id="theme_list"></ul>                    
    </div>
    <div class="right">
        <div class="top_right_menu">
            <i id="leftMenu" class="material-icons" title="Список тем"><!--КНОПКА появления левого меню left: 0;-->menu</i>
            <div class="user">
                <div class="status_name"></div>
                <input type="text" class="edit_status_name" value="">
                <div class="status_members"></div>
            </div>
            <i id="notification_check" class="material-icons" title="Уведомления">notifications</i>
            <i id="toggleSound" class="material-icons" onclick="toggleSound();" title="Выключить звук"><?php echo getSound(); ?></i> <!--Кнопка отключения/включения звука-->
            <i id="exit" class="material-icons" title="Выйти">input</i> <!--Кнопка выхода из аккаунта-->
            <div class="notification_window">
                <!--Окно уведомлений-->
                <div class="notification_node">
                    <div class="not_node">
                        <p class="date"><i class="material-icons">event</i>21 авг 16:54</p>
                        <span>Вас добавили в тему:</span>
                        <a href="">Домашняя тема</a>
                    </div>
                    <i class="material-icons" title="Закрыть">close</i>
                </div>
                <div class="notification_node">
                    <div class="not_node">
                        <p class="date"><i class="material-icons">event</i>21 авг 16:54</p>
                        <span>В теме <a href="">Домашняя тема</a> добавлена задача:</span>
                        <a href="">Настроить окно уведомлений</a>
                    </div>
                    <i class="material-icons" title="Закрыть">close</i>
                </div>
                <div class="notification_node">
                    <div class="not_node">
                        <p class="date"><i class="material-icons">event</i>21 авг 16:54</p>
                        <span>Задача <a href="">Настроить окно уведомлений</a> принята в работу</span>
                    </div>
                    <i class="material-icons" title="Закрыть">close</i>
                </div>
                <div class="notification_node">
                    <div class="not_node">
                        <p class="date"><i class="material-icons">event</i>21 авг 16:54</p>
                        <span>Задача <a href="" title="Закрыть">Настроить окно уведомлений</a> выполнена</span>
                    </div>
                    <i class="material-icons">close</i>
                </div>
            </div>
        </div>
        <div class="center_right">
            <div class="task_window"><!--Задачи-->
                <div class="col_need_to_do">
                    <h3>Нужно сделать</h3>
                    <i id="addTask" class="material-icons">add</i>
                    <div class="dropZone" id="container_need_to_do" dropzone="true" ondragenter="drag_enter(event)" ondragleave="drag_leave(event)" ondrop="drag_drop(event)" ondragover="return false"></div>
                </div>
                <div class="col_in_work">
                    <h3>В работе</h3>
                    <div class="dropZone" id="container_in_work" dropzone="true" ondragenter="drag_enter(event)" ondragleave="drag_leave(event)" ondrop="drag_drop(event)" ondragover="return false"></div>
                </div>
                <div class="col_done">
                    <h3>Выполнено</h3>
                    <div class="dropZone" id="container_done" dropzone="true" ondragenter="drag_enter(event)" ondragleave="drag_leave(event)" ondrop="drag_drop(event)" ondragover="return false"></div>
                </div>
                <div class="card">

                </div>
            </div>
            <div id="resize" class="resize"><!--изменение размера окна--></div>
            <div class="chat" id="chat"><!--Чат--></div>
        </div>                    
        <div class="input_msg">
            <i id="attach_file" class="material-icons" title="Вложить">attach_file</i>
            <textarea name="textarea" id="textarea" placeholder="Напишите сообщение..."></textarea>                   
            <i id="emojiButton" class="material-icons">mood</i><!--Модзи-->
            <i id="textarea_send" class="material-icons" title="Отправить">send</i>
        </div>
    </div>
    <div class="modal" id="modal_window"></div><!--Добавление темы-->
    <div class="modal-2" id="modal-2_window"></div><!--Пользователи-->
    <div class="modzy_window">
        <div></div>
    </div><!--Добавление модзи-->
</div>