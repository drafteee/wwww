<?php

/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 24.04.2016
 * Time: 21:28
 */
class ChatUser extends ChatBase{

protected $name = '';

    public function save($db){
        print_r($this->name);
        echo "3";
        mysqli_query($db,"INSERT INTO webchat_users (user,last_activity) VALUES('".($this->name)."','".date("Y-m-d H:i:s")."')");
    }

    public function update(){
        DB::query("
            INSERT INTO webchat_users (name, gravatar)
            VALUES (
                '".DB::esc($this->name)."',
                '".DB::esc($this->gravatar)."'
            ) ON DUPLICATE KEY UPDATE last_activity = NOW()");
    }
}
