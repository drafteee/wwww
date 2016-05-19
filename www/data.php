<?php 

	require_once 'classes.php';
	require_once 'index.php';
	require_once 'Users.php';
	require_once 'Comunity.php';
	$publications = array();


	function SortType($type,$array,$publications)
	{
		foreach ($array as $arr) {
			foreach ($arr as $key => $value) {
				if ($key == "category_id") {
					if (stripos($value, $type) != false) {
						array_push($publications, $arr);
					}
				}
			}
		}
		return $publications;
	}

	function ReturnInfoUser($index,$array,$arrayUserInfo){

		foreach($array as $arr){
			foreach($arr as $key=>$value)
				if(($key=="id_user")){
					if(stripos($index,$value) != false) {
						$arrayUserInfo = $arr;
					}
				}
		}
		return $arrayUserInfo;
	}



session_start("start");

if(isset($_POST["page"]))
	switch($_POST["page"]){
		case "index1":{
			$str = "";
			if($_POST["type"]=="All News"){
				$str =$index->GenerateNewNews(Get("news",Connect()));
			}else
				$str = $index->GenerateNewNews(SortType($_POST["type"],Get("news",Connect()),$publications));
			echo $str;
			break;
		}
		case "index":{
			$index->GenerateNewNews(Get("news",Connect()));
			break;
		}
		case "offer":{
			if(isset($_POST["text"]))
				Add(Connect());
			break;
		}
		case "users":{
			$arrayUserInfo = array();
			$UsersObj->Get_array_info_user(ReturnInfoUser($_POST["index"],Get("users",Connect()),$arrayUserInfo));
			echo ($UsersObj->Get_array_info_user(ReturnInfoUser($_POST["index"],Get("users",Connect()),$arrayUserInfo)));
			break;
		}
		case "registr":{
			echo "1";
			$db = Connect();
			AddUser($db);
			$_SESSION['user']['name'] = $_POST['login'];
			break;
		}
		case "home":{
			if(isset($_SESSION['user']['name']))
				echo($_SESSION['user']['name']);
			break;
		}
		case"login":{
			$db = Connect();
			Login($db);
			echo($_SESSION['user']['name']);
			break;
		}
		case"home_info":{
			$db = Connect();
			print_r(GetInfoUserjs($db));
			break;
		}
		case "Save":{
			$db = Connect();
			EditUser($db);
			break;
		}
		case"Exit":{
			$_SESSION['user']['name'] = null;
			break;
		}
		case"Recovery":{
			$db = Connect();
			RecoveryPass($db);
			echo($_SESSION['user']['name']);
			break;
		}
		case "chat":{
			AddChat(Connect());
			break;
		}
		case "update_users":{
			$str = $comunityObj->GenerateUsers(Get("users",Connect()));
			echo $str;
			break;
		}
		case"update_msg":{
			$str = $comunityObj->GenerateMsg(Get("webchat_lines",Connect()));
			echo $str;
			break;
		}
	}
?>