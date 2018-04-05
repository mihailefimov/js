<?php

// Точка входа
function registerUser() {
   
    if (!checkHttpMethod()) {
        error_log('HTTP METHOD IS NOT POST');
        redirectToErrorPage();
    }


    $userCredentials = cleanUserInput();

    
    if (!comparePasswords($userCredentials['password'], $userCredentials['password2'])) {
        error_log('PASSWORDS NOT EQUAL');
        redirectToErrorPage();
    }

    // подключаем БД
    require_once '../bd/bd.php';

    /*
     * Проверяем, есть ли у нас такой пользователь с уже таким же email
     */
    if (checkExistingUser($userCredentials['email'])) {
        error_log('existing email = ' . $userCredentials['email']);
        error_log('USER ALREADY EXIST');
        redirectToErrorPage();
    }

    /*
     * Создаем пользователя (заносим данные в базу данных)
     */
    createUser($userCredentials);
    // перенаправляем на страницу авторизации
    header('Location: auth.php');
}

function checkHttpMethod() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return true;
    }
}

function redirectToErrorPage() {
    header("HTTP/1.1 404 Not Found");
    header("Location: ../404.html");
    die;
}

function cleanUserInput() {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $group_number = $_POST['group_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $cleanedUserInput = array(
        'name' => cleanString($name),
        'surname' => cleanString($surname),
        'group_number' => cleanString($group_number),
        'email' => cleanString($email),
        'password' => cleanString($password),
        'password2' => cleanString($password2),
    );

    return $cleanedUserInput;
}

function cleanString($textFromUser) {
    $convertedToHtmlEntities = htmlspecialchars($textFromUser, ENT_QUOTES);
    return $convertedToHtmlEntities;
}

function comparePasswords($pass, $pass2) {
    return $pass === $pass2;
}

//function checkExistingUser($email, $login) {
function checkExistingUser($email) {
    $sql = "SELECT user_id FROM users WHERE email = :email";
    $stmt = $GLOBALS['dbConnection']->prepare($sql);
    $stmt->execute(array(
        ":email" => $email
    ));
    $userExist = $stmt->fetchColumn();
    return $userExist;
}

function createUser($userData) {
    $sql = "INSERT INTO users VALUES (?,?,?,?,?,?,?)";
    $stmt = $GLOBALS['dbConnection']->prepare($sql);
    $stmt->execute(array(
        'default',
        $userData['email'],
        $userData['name'],
        $userData['surname'],
        $userData['group_number'],
        md5($userData['password'] . PASSWORD_SALT),
        PASSWORD_SALT
    ));
}

// Точка входа
registerUser();

