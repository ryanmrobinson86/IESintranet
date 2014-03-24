<?php
@session_start();
ini_set('display_errors','On');
error_reporting(E_STRICT);
$refresh = "index.php";
if(isset($_SERVER['HTTP_REFERER'])){
	$refresh = $_SERVER['HTTP_REFERER'];
}

if(isset($_POST['userName']) && isset($_POST['userPwd'])){
	$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Cannot Connect to Database\n");
	$query = "SELECT pass_usr, level_usr, svn_usr FROM users_usr WHERE usrname_usr = '".$_POST['userName']."'";
	$rs = pg_query($conn,$query) or die("Could not execute query: $query");
	if($row = pg_fetch_assoc($rs)){
		if($row['pass_usr'] === $_POST['userPwd']){
			setcookie('username',$_POST['userName'],time()+60*60*24*30,'/');
			setcookie('userLevel',$row['level_usr'],time()+60*60*24*30,'/');
			setcookie('usersvn',$row['svn_usr'],time()+60*60*24*30,'/');
		}
	}
}else{
	setcookie('username',0,time()-60*60*24*30,'/');
	setcookie('userLevel',0,time()-60*60*24*30,'/');
	setcookie('usersvn',0,time()-60*60*24*30,'/');
}
header("Location: $refresh");
?>
