<?php

/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 24.04.2016
 * Time: 21:30
 */
/* Класс Chat содержит публичные статические методы, которые используются в ajax.php */
class Chat
{

    public static function login($name,$db)
    {
        $user = new ChatUser(array(
            'name' => $name,
        ));
        // Метод save возвращает объект MySQLi
        $user->save($db);

        $_SESSION['user'] = array(
            'name' => $name
        );
        return array(
            'status' => 1,
            'name' => $name,
        );
    }

    public static function checkLogged()
    {
        $response = $_SESSION['user'];
        return $response;
    }

    public static function logout()
    {
        DB::query("DELETE FROM webchat_users WHERE name = '" . DB::esc($_SESSION['user']['name']) . "'");
        $_SESSION = array();
        unset($_SESSION);
        return array('status' => 1);
    }

    public static function submitChat($chatText){
        if(!$_SESSION['user']){
            throw new Exception('Вы вышли из чата');
        }

        if(!$chatText){
            throw new Exception('Вы не ввели сообщение.');
        }
        $chat = new ChatLine(array(
            'author'    => $_SESSION['user']['name'],
            'text'      => $chatText
        ));

        // Метод save возвращает объект MySQLi
        $insertID = $chat->save()->insert_id;
        return array(
            'status'    => 1,
            'insertID'  => $insertID
        );
    }
    public static function getUsers(){
        if($_SESSION['user']['name']){
            $user = new ChatUser(array('name' => $_SESSION['user']['name']));
            $user->update();
        }
        // Удаляем записи чата старше 5 минут и пользователей, неактивных в течении 30 секунд
        DB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
        DB::query("DELETE FROM webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:30')");
        $result = DB::query('SELECT * FROM webchat_users ORDER BY name ASC LIMIT 18');
        $users = array();
        while($user = $result->fetch_object()){
            $user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
            $users[] = $user;
        }
        return array(
            'users' => $users,
            'total' => DB::query('SELECT COUNT(*) as cnt FROM webchat_users')->fetch_object()->cnt
        );
    }
    public static function getChats($lastID){
        $lastID = (int)$lastID;
        $result = DB::query('SELECT * FROM webchat_lines WHERE id > '.$lastID.' ORDER BY id ASC');
        $chats = array();
        while($chat = $result->fetch_object()){
            // Возвращаем время создания сообщения в формате GMT (UTC):
            $chat->time = array(
                'hours'     => gmdate('H',strtotime($chat->ts)),
                'minutes'   => gmdate('i',strtotime($chat->ts))
            );
            $chat->gravatar = Chat::gravatarFromHash($chat->gravatar);

            $chats[] = $chat;
        }
        return array('chats' => $chats);
    }
}