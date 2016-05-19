<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 24.04.2016
 * Time: 21:19
 */

/* Конфигурация базы данных. Добавьте свои данные */
$dbOptions = array(
    'db_user' => '',
    'db_pass' => '',
    'db_nick' => ''
);
/* Конец секции конфигурации базы данных */
error_reporting(E_ALL ^ E_NOTICE);

require_once "DB.php";
require_once "Chat.php";
require_once "ChatBase.php";
require_once "ChatLine.php";
require_once "ChatUser.php";
require_once "classes.php";

session_name('webchat');
session_start();

try{
    // Соединение с базой данных

    $db  =Connect();
    $response = array();
    // Обработка поддерживаемых действий:
    switch($_POST['action']){
        case 'login':
            $response = Chat::login($_POST['name'],$db);
        break;
        case 'checkLogged':
            $response = Chat::checkLogged();
        break;
        case 'logout':
            $response = Chat::logout();
        break;
        case 'submitChat':
            $response = Chat::submitChat($_POST['chatText']);
        break;
        case 'getUsers':
            $response = Chat::getUsers();
        break;
        case 'getChats':
            $response = Chat::getChats($_GET['lastID']);
        break;
        default:
            throw new Exception('Wrong action');
    }
    echo json_encode($response);

}
catch(Exception $e){
    die(json_encode(array('error' => $e->getMessage())));
}