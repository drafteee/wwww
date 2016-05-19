<?php

error_reporting(E_ALL);
require_once 'classes.php';

class Comunity{

    public function __constructor($publications){
        $array_list_news  = array();
        foreach ($publications as $array)
        {
            array_push($array_list_news,array("user"=>"online_user_".$array['id_user'],"text"=>$array['nick_name']));
        }
        return $array_list_news;
    }

  private $array_header_ul = array(
		array("href"=>"index.php","link"=>"Главная"),
		array("href"=>"Discussions.php","link"=>"Обсуждения"),
        array("href"=>"Comunity.php","link"=>"Общение"),
        array("href"=>"Offer.php","link"=>"Предложить"),
        array("href"=>"Users.php","link"=>"Пользователи")
	);

    public function __constr($publications){
        $array_list_news  = array();
        foreach ($publications as $array)
        {
            array_push($array_list_news,array("author"=>"online_user_".$array['author'],"text"=>$array['author']." : ".$array['text']));
        }
        return $array_list_news;
    }

    public  function GenerateMsg($publications){
        $array_list_news = $this->__constr($publications);
        $msg_tpl = file_get_contents("includes/class/msg.tpl");
        return $this->Generate_li($msg_tpl,$array_list_news);;
    }
    public function GenerateUsers($publications){
        $array_list_news = $this->__constructor($publications);
        $list_users_tpl = file_get_contents("includes/class/list_users.tpl");
        return $this->Generate_li($list_users_tpl,$array_list_news);
    }
      
    public function Generate_li($ul_header_tpl,$array_header_ul){
        
      $generate_str ="";
      
      foreach ($array_header_ul as $array){
          $additional_value=$ul_header_tpl;

          foreach($array as $key=>$values){
              $additional_value = str_replace('{'.$key.'}', $values, $additional_value);
          }

          $generate_str .= $additional_value;
      } 
      
      
      return $generate_str;
    }
    
    public function Create_ul($class_name_ul,$generate_str){
            $ul_str = '<ul class="%s">%s</ul>';
            $ul_str = sprintf($ul_str,$class_name_ul,$generate_str);
        return $ul_str;
    }
      
    
  
	public function Generate_Comunity(){
		$index_tpl = file_get_contents("includes/class/Comunity.tpl");
        $header_tpl = file_get_contents("includes/class/header.tpl");
        $ul_tpl = file_get_contents("includes/class/ul_.tpl");
        $list_users_tpl = file_get_contents("includes/class/list_users.tpl");
        $content_right_tpl = file_get_contents("includes/class/content_right.tpl");
        $footer_tpl = file_get_contents('includes/class/footer.tpl');
        $modal_window_tpl = file_get_contents('includes/class/modal_window.tpl');
        
        $header_tpl = str_replace('{ul_header}',$this->Create_ul("sidebar",$this->Generate_li($ul_tpl,$this->array_header_ul)),$header_tpl);
        
        $array_users = $this->__constructor(Get("users",Connect()));

        $index_tpl = str_replace('{list_users}',$this->Generate_li($list_users_tpl,$array_users),$index_tpl);
      
        $index_tpl = str_replace('{header}',$header_tpl,$index_tpl);
        $index_tpl = str_replace('{content_right}',$content_right_tpl,$index_tpl);
        $index_tpl = str_replace('{footer}',$footer_tpl,$index_tpl);
        $index_tpl = str_replace('{modal_window}',$modal_window_tpl,$index_tpl);
        echo $index_tpl;
	}   
        
}

$comunityObj = new Comunity();
if(!isset($_POST["page"])) {

    $comunityObj->Generate_Comunity();
}