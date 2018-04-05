<?php

/*
 * точка входа
 */
function authenticate() {
    /*
     * Если нам прислали поля email и pass, то очищаем их и идем далее
     */
    if (isset($_POST['email']) && isset($_POST['pass'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['pass']);

        require_once '../bd/bd.php';
        /*
         * генерим хэш от пароля (на самом деле md5 уже далеко не безопасно).
         * Но по хешированию я спрашивал, ответа не было. Всегда можно махнуть
         */
        $hashPass = md5($password . PASSWORD_SALT);

        /*
         * Ищем в базе, есть ли у нас юзер с таким email и паролем
         */
        $sql = 'SELECT * FROM users WHERE email=:email AND pass=:pass';
        $stmt = $GLOBALS['dbConnection']->prepare($sql);
        $stmt->execute(array(
            ":email" => $email,
            ":pass" => $hashPass
        ));
        $userExist = $stmt->fetchColumn();
        /*
         * Если есть, то создаем для него сессию и редиректим в личный кабинет
         */
        if ($userExist) {
            session_start();
            $_SESSION['email'] = $email;
            header('Location: profile.php');
        /*
         * Если нет, то выводим сообщение об ошибке
         */
        } else {
            echo '<script>alert("Неверный логин и/или пароль!")</script>';
        }
    }
}

authenticate();

include 'auth_form.html';


