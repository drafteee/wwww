<?php

/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 24.04.2016
 * Time: 21:26
 */
/* Строка чата */

class ChatLine extends ChatBase{
    protected $text = '', $author = '', $gravatar = '';

    public function save(){
        DB::query("
            INSERT INTO webchat_lines (author, gravatar, text)
            VALUES (
                '".DB::esc($this->author)."',
                '".DB::esc($this->gravatar)."',
                '".DB::esc($this->text)."'
        )");
        // Возвращаем объект MySQLi класса DB
        return DB::getMySQLiObject();
    }
}
