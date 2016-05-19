<?php

error_reporting(E_ALL);
require_once 'classes.php';
class Discussions{

    public function __constructor($publications){
        $array_discussions  = array();
        foreach ($publications as $array)
        {
            array_push($array_discussions,array("number_disc"=>"discussion_".$array['id_disc'],"href"=>"#modal1","link"=>$array['text']));
        }
        return $array_discussions;
    }
  
  private $array_header_ul = array(
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
    
	public function Generate_Discussions(){
		$index_tpl = file_get_contents("includes/class/Discussions.tpl");
        $header_tpl = file_get_contents("includes/class/header.tpl");
        $ul_tpl = file_get_contents("includes/class/ul_.tpl");
        $footer_tpl = file_get_contents('includes/class/footer.tpl');
        $modal_window_tpl = file_get_contents('includes/class/modal_window.tpl');
        $ul_list_discussions_tpl = file_get_contents('includes/class/ul_list_discussions.tpl');
        
        $header_tpl = str_replace('{ul_header}',$this->Create_ul("sidebar",$this->Generate_li($ul_tpl,$this->array_header_ul)),$header_tpl);
        
        $array_discussions = $this->__constructor(Get("discussions",Connect()));
        
        $ul_list_discussions_tpl = str_replace('{ul_header}',$this->Create_ul("list",$this->Generate_li($ul_tpl,$array_discussions)),$ul_list_discussions_tpl);
      
        $index_tpl = str_replace('{header}',$header_tpl,$index_tpl);
        $index_tpl = str_replace('{ul_list_discussions}',$ul_list_discussions_tpl,$index_tpl);
        $index_tpl = str_replace('{footer}',$footer_tpl,$index_tpl);
        $index_tpl = str_replace('{modal_window}',$modal_window_tpl,$index_tpl);
        echo $index_tpl;
	}   
        
}

$discussionsObj = new Discussions();
$discussionsObj->Generate_Discussions();