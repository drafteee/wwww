<?php

error_reporting(E_ALL);


class Offer{

  public function __constructor(){    
     $array_check = array(
        array("class_name"=>"check_left","text1"=>"Новости","text2"=>"","name_checkbox"=>"Checkbox_1","value"=>"News"),
        array("class_name"=>"check_right","text1"=>"","text2"=>"Подслушано","name_checkbox"=>"Checkbox_2","value"=>"Pods")
    );

  
    return $array_check;
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
      
    
  
	public function Generate_Offer(){
		$index_tpl = file_get_contents("includes/class/Offer.tpl");
        $header_tpl = file_get_contents("includes/class/header.tpl");
        $ul_tpl = file_get_contents("includes/class/ul_.tpl");
        $check_tpl = file_get_contents("includes/class/check.tpl");
        $content_middle_top_tpl = file_get_contents("includes/class/content_middle_top.tpl");
        $content_middle_bottom_tpl = file_get_contents("includes/class/content_middle_bottom.tpl");
        $content_bottom_tpl = file_get_contents("includes/class/content_bottom.tpl");
        $footer_tpl = file_get_contents('includes/class/footer.tpl');
        $modal_window_tpl = file_get_contents('includes/class/modal_window.tpl');
        
        $header_tpl = str_replace('{ul_header}',$this->Create_ul("sidebar",$this->Generate_li($ul_tpl,$this->array_header_ul)),$header_tpl);
        
        $array_check = $this->__constructor();
        $index_tpl = str_replace('{check}',$this->Generate_li($check_tpl,$array_check),$index_tpl);
          
        $index_tpl = str_replace('{header}',$header_tpl,$index_tpl);
        $index_tpl = str_replace('{content_middle_top}',$content_middle_top_tpl,$index_tpl);
        $index_tpl = str_replace('{content_middle_bottom}',$content_middle_bottom_tpl,$index_tpl);
        $index_tpl = str_replace('{content_bottom}',$content_bottom_tpl,$index_tpl);
      
        $info_content = '<div class="info_content"><span class="left_text">Предложить</span><span class="right_text">    новость</span></div>';
        $index_tpl = str_replace('{info_content}',$info_content,$index_tpl);
        $index_tpl = str_replace('{footer}',$footer_tpl,$index_tpl);
        $index_tpl = str_replace('{modal_window}',$modal_window_tpl,$index_tpl);
        echo $index_tpl;
	}   
        
}
$OfferObj = new Offer();
$OfferObj->Generate_Offer();

