<?php

error_reporting(E_ALL);
require_once 'classes.php';

class Users{

    public function __constructor($publications){
        $array_list_news  = array();
        foreach ($publications as $array)
        {
            array_push($array_list_news,array("user"=>"online_user_".$array['id_user'],"text"=>$array['name_user']));
        }
        return $array_list_news;
    }

  private $array_header_ul = array(
		array("href"=>"Index.php","link"=>"Главная"),
		array("href"=>"Discussions.php","link"=>"Обсуждения"),
        array("href"=>"Comunity.php","link"=>"Общение"),
        array("href"=>"Offer.php","link"=>"Предложить"),
        array("href"=>"Users.php","link"=>"Пользователи")
	);

    public function Get_array_info_user_start(){
        $array_info_user = array(
            array("text"=>"Nickname:","info"=>""),
            array("text"=>"Name:","info"=>""),
            array("text"=>"City:","info"=>""),
            array("text"=>"Level:","info"=>""),
            array("text"=>"Old:","info"=>""),
            array("text"=>"More:","info"=>"")
        );
        return $array_info_user;
    }
  public function Get_array_info_user($infousers){
      $array_info_user = array(
        array("text"=>"Nickname:","info"=>$infousers["nick_name"]),
        array("text"=>"Name:","info"=>$infousers["name_user"]),
        array("text"=>"City:","info"=>$infousers["city"]),
        array("text"=>"Level:","info"=>$infousers["level"]),
        array("text"=>"Old:","info"=>$infousers["old"]),
        array("text"=>"More:","info"=>$infousers["more"])
      );
      $list_users_tpl = file_get_contents("includes/class/content_right_top.tpl");

    return $this->Create_ul("info_user",$this->Generate_li($list_users_tpl,$array_info_user));
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
    
    public function Create_news($array_list_news){
      $str ='<div class="content_body_list_news" id="id_content_body_list_news">%s</div>';
      $content_body_list_tpl = file_get_contents("includes/class/content_body_list_news.tpl");
      $str = sprintf($str,$this->Generate_li($content_body_list_tpl,$array_list_news));  
      return $str;
    }
  
	public function Generate_Users(){
		$index_tpl = file_get_contents("includes/class/Users.tpl");
        $header_tpl = file_get_contents("includes/class/header.tpl");
        $ul_tpl = file_get_contents("includes/class/ul_.tpl");
        $list_users_tpl = file_get_contents("includes/class/list_users.tpl");
        $content_right_top_tpl = file_get_contents("includes/class/content_right_top.tpl");
        $footer_tpl = file_get_contents('includes/class/footer.tpl');
        $modal_window_tpl = file_get_contents('includes/class/modal_window.tpl');
        
        $header_tpl = str_replace('{ul_header}',$this->Create_ul("sidebar",$this->Generate_li($ul_tpl,$this->array_header_ul)),$header_tpl);
        $array_users = $this->__constructor(Get("users",Connect()));


        $index_tpl = str_replace('{list_users}',$this->Generate_li($list_users_tpl,$array_users),$index_tpl);

        $array_info_user = $this->Get_array_info_user_start();
        $index_tpl = str_replace('{content_right_top}',$this->Generate_li($content_right_top_tpl,$array_info_user),$index_tpl);
        $index_tpl = str_replace('{header}',$header_tpl,$index_tpl);
        $index_tpl = str_replace('{footer}',$footer_tpl,$index_tpl);
        $index_tpl = str_replace('{modal_window}',$modal_window_tpl,$index_tpl);
        echo $index_tpl;
	}   
        
}

$UsersObj = new Users();
if(!isset($_POST["page"])) {

    $UsersObj->Generate_Users();
}