<?php
/*
 * Это контроллер, который принимает с фронта данные о результатах теста.
 * После прохождения теста средствами JS (location.href="...") нас редиректит на примерно такой URL:
 * answerController.php??rightAnswers=3&testId=1&all=6"
 * Что здесь за параметры?
 * rightAnswers - количество верных ответов
 * testId - номер теста
 * all - количество вопросов в тесте
 */

session_start();
/*
 * Если сессии нет, то редиректим на страницу авторизации
 */
if (!isset($_SESSION['email'])) {
    header('Location: auth.php');
}

function saveResults($rightAnswers, $testId, $email, $all) {
    require_once '../bd/bd.php';

    /*
     * Ищем в БД, проходил ли ранее юзер этот тест
     */
    $sql = "SELECT * FROM test_results WHERE test_id=? AND user_email=?";
    $stmt = $GLOBALS['dbConnection']->prepare($sql);
    $stmt->execute(array(
        $testId,
        $email
    ));
    $result = $stmt->fetchColumn();
    /*
     * Если проходил, то просто обновляем поле правильных ответов
     */
    if ($result) {
        $sql = "UPDATE test_results SET rightAnswers=? WHERE test_id=? AND user_email=?";
        $stmt = $GLOBALS['dbConnection']->prepare($sql);
        $stmt->execute(array(
            $rightAnswers,
            $testId,
            $email
        ));
    /*
     * Если не проходил, то создаем запись в БД
     */
    } else {
        $sql = "INSERT INTO test_results VALUES(?,?,?,?)";
        $stmt = $GLOBALS['dbConnection']->prepare($sql);
        $stmt->execute(array(
            $testId,
            $rightAnswers,
            $all,
            $email
        ));
    }
}

if (isset($_GET['rightAnswers']) && isset($_GET['testId'])) {
    $rightAnswers = htmlspecialchars($_GET['rightAnswers']);
    $testId = htmlspecialchars($_GET['testId']);
    $all = htmlspecialchars($_GET['all']);
    $email = $_SESSION['email'];
    saveResults($rightAnswers, $testId, $email, $all);
    header('Location: profile.php');

}