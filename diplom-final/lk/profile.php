<?php

    session_start();
    /*
     * Если сессии нет, то редиректим на страницу авторизации
     */
    if (!isset($_SESSION['email'])) {
        header('Location: auth.php');
    }

    include '_profile.html';
?>
