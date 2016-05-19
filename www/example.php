<?php

$Connect = mysqli_connect("localhost","root","","list_news");

if(!$Connect){
	exit("Ошибка подключения к бд!"); 
}
?>