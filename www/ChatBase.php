<?php

/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 24.04.2016
 * Time: 21:25
 */
/* Базовый класс, который используется классами ChatLine и ChatUser */

class ChatBase{
    // Данный конструктор используется всеми класса чата:
    public function __construct(array $options){
        foreach($options as $k=>$v){
            if(isset($this->$k)){
                $this->$k = $v;
            }
        }
    }
}
