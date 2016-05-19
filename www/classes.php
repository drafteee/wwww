<?php 
error_reporting(E_ALL);
function Connect(){
	$con = mysqli_connect("localhost","root","","list_news");
	if(!$con){
		exit("Ошибка подключения к БД!");
	}
	//$con->set_charset('utf8');
	return $con;
}
function CheckSQL($con,$arr){
	$returnArray = [];
	foreach($arr as $key=>$value){
		$returnArray[$key] = mysqli_real_escape_string($con, $arr[$key]);
	}
	return $returnArray;
}
function AddChat($db){
	$arr = array('author'=>$_POST['author'],'text'=> $_POST['text']);
	$arr = CheckSQL($db,$arr);
	mysqli_query($db,"INSERT INTO webchat_lines(author,text) VALUES ('".$arr['author']."','".$arr['text']."')");
}
function EditUser($db){
	$arr = array('name'=>$_POST['name'],'login'=> $_POST['login'],'city'=> $_POST['city'],'old'=>$_POST['old'],'mail'=>$_POST['mail']);
	$arr = CheckSQL($db,$arr);
	mysqli_query($db,"UPDATE users
							SET	name_user='".$arr['name']."',
							password = '".HashPass()."',
							nick_name='".$arr['login']."',
							city='".$arr['city']."',
							old='".(int)$arr['old']."',
							`e-mail`='".$arr['mail']."'
						WHERE nick_name='".$_SESSION['user']['name']."'");
	$_SESSION['user']['name'] = $arr['login'];
}
function Add($con){
	$arr = array('content'=>$_POST['text'],'date'=> date("Y-m-d H:i:s"),'author_id'=> $_POST['author'],'category_id'=>$_POST['category'],'status'=>1);
	$arr = CheckSQL($con,$arr);
	mysqli_query($con,"INSERT INTO news (content,date,author_id,category_id,status) VALUES('".$arr['content']."','".$arr['date']."','".$arr['author_id']."','".$arr['category_id']."','".$arr['status']."')");
}
function HashPass(){
	$salt = "2j5vdfs6";
	$str = $_POST['pass'];
	$str = $salt.$str;
	$str = sha1(md5($str));
	return $str;
}
function HashRec($str){
	$salt = "gdsages34";
	$str = $salt.$str;
	$str = sha1(md5($str));
	return $str;
}
function generatePassword(){
	$length = 8;
	$chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
	$numChars = strlen($chars);
	$string = '';
	for ($i = 0; $i < $length; $i++) {
		$string .= substr($chars, rand(1, $numChars) - 1, 1);
	}
	return $string;
}
function RecoveryPass($db){
	$arr = array('login'=> $_POST['login']);
	$arr = CheckSQL($db,$arr);
	$res = mysqli_query($db,"SELECT * FROM users WHERE nick_name='".$arr['login']."'");
	$res = mysqli_fetch_array($res);
	$key = ($str = generatePassword());
	mysqli_query($db,"UPDATE users
							SET	password = '".HashRec($key)."'
							WHERE nick_name='".$arr['login']."'");
	mail($res['e-mail'], "Восстановление пароля", "Зайдите на страницу под временным паролем: ".$key.".\n Изменить пароль сможете в вашем кабинете.");
}
function AddUser($db){
	$arr = array('name'=>$_POST['name'],'login'=> $_POST['login'],'city'=> $_POST['city'],'old'=>$_POST['old'],'mail'=>$_POST['mail']);
	$arr = CheckSQL($db,$arr);
	mysqli_query($db,"INSERT INTO users (name_user,password,nick_name,city,`level`,old,`more`,`e-mail`,registration_date)
	VALUES ('".$arr['name']."','".HashPass()."','".$arr['login']."','".$arr['city']."',1,'".(int)$arr['old']."',' ','".$arr['mail']."','".date("Y-m-d H:i:s")."')");
	mail($arr['mail'], "Регистрация на сайте", "Вы зарегистрировались на сайте InfoCity. Ваш логин ".$arr['login'].".");
}
function Login($db){
	$flag = false;
	print_r($_POST);
	$arr = array('pass'=>$_POST['pass'],'login'=> $_POST['login']);
	$arr = CheckSQL($db,$arr);
	print_r($arr);
	echo HashPass();
	$arrayUsers = Get("users",$db);
	foreach($arrayUsers as $array)
		foreach($array as $key=>$value)
			if($key=="nick_name")
				if($value==$arr['login'])
					foreach($array as $key=>$value)
						if($key=="password")
							if(($value==HashRec($arr['pass']))||($value==HashPass())) {
								$flag = true;
								break;
							}
	if($flag){
		$_SESSION['user'] = array('name'=>$arr['login']);
	}
}
function GetInfoUserjs($db){
	$nick = $_POST['login'];
	$res = mysqli_query($db,"SELECT * FROM users WHERE nick_name='$nick'");
	return json_encode(mysqli_fetch_array($res));
}
function Get($name_table,$con){

	$result = mysqli_query($con,"SELECT * FROM $name_table");

	$additionalArray = array();
	while($row = mysqli_fetch_assoc($result)){
		$additionalArray[] = $row;
	};

	if($name_table!="webchat_lines")
		$additionalArray = array_reverse($additionalArray);
	return $additionalArray;
}
?>