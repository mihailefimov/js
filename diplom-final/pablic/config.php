<?php
 /**
 * Конфигурационный файл
 * Site: http://bezramok-tlt.ru
 * Регистрация пользователя письмом
 */

 //Ключ защиты
// if(!defined('BEZ_KEY'))
// {
//     header("HTTP/1.1 404 Not Found");
//     exit(file_get_contents('../404.html'));
// }

 //Адрес базы данных
 define('BEZ_DBSERVER','localhost');

 //Логин БД
 define('BEZ_DBUSER','root');

 //Пароль БД
 define('BEZ_DBPASSWORD','');

 //БД
 define('BEZ_DATABASE','bez_reg');

 //Префикс БД
 define('BEZ_DBPREFIX','bez_');

 //Errors
 define('BEZ_ERROR_CONNECT','Не могу соедениться с БД');

 //Errors
 define('BEZ_NO_DB_SELECT','Данная БД отсутствует на сервере');

 //Адрес хоста сайта
 define('BEZ_HOST','http://'. $_SERVER['HTTP_HOST'] .'/');
 
 //Адрес почты от кого отправляем
 define('BEZ_MAIL_AUTOR','<info@camline24.ru>');

 define('PASSWORD_SALT', '6b5484b5');

 ?>