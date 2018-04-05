<?php

session_start();

/*
 * Уничтожаем сессию пользователя при логауте
 */
unset($_SESSION['email']);
session_destroy();
/*
 * Редиректим на страницу авторизации
 */
header('Location: auth.php');