<?php

error_reporting(E_ALL);
require_once 'classes.php';
class Index{

  public function __constructor($publications){
    $array_list_news  = array();
    foreach ($publications as $array)
    {
      array_push($array_list_news,array("number_news"=>"content_body_".$array['id']."_new","href"=>"#modal1","text"=>$array['content']));
    }
     return $array_list_news;
  }
    
  public function  GenerateNewNews($publications){
      $array_list_news = $this->__constructor($publications);

      return $this->Create_news($array_list_news);
  }
  public $array_header_ul = array(
		array("href"=>"index.php","link"=>"Главная"),
		array("href"=>"Discussions.php","link"=>"Обсуждения"),
        array("href"=>"Comunity.php","link"=>"Общение"),
        array("href"=>"Offer.php","link"=>"Предложить"),
        array("href"=>"Users.php","link"=>"Пользователи")
	);
	
    
      
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
  
	public function Generate_Index(){
        $index_tpl = file_get_contents("includes/class/index.tpl");
        $header_tpl = file_get_contents("includes/class/header.tpl");
        $content_header_tpl = file_get_contents("includes/class/content_header.tpl");
        $side_bar_type_news_tpl = file_get_contents("includes/class/side_bar_type_news.tpl");
        $ul_header_tpl = file_get_contents("includes/class/ul_.tpl");
        $footer_tpl = file_get_contents('includes/class/footer.tpl');
        $modal_window_tpl = file_get_contents('includes/class/modal_window.tpl');

        $array_list_news =$this->__constructor(Get("news",Connect()));
        $header_tpl = str_replace('{ul_header}',$this->Create_ul("sidebar",$this->Generate_li($ul_header_tpl,$this->array_header_ul)),$header_tpl);

        $index_tpl = str_replace('{content_body_list_news}', $this->Create_news($array_list_news), $index_tpl);

        $index_tpl = str_replace('{header}',$header_tpl,$index_tpl);
        $index_tpl = str_replace('{content_header}',$content_header_tpl,$index_tpl);
        $index_tpl = str_replace('{side_bar_type_news}',$side_bar_type_news_tpl,$index_tpl);
        $index_tpl = str_replace('{footer}',$footer_tpl,$index_tpl);
        $index_tpl = str_replace('{modal_window}',$modal_window_tpl,$index_tpl);
        echo $index_tpl;
	}   
        
}
$index = new Index();
if(!isset($_POST["page"])){

    $index->Generate_Index();
}