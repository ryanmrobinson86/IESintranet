<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
@session_start();
if(isset($_GET['i'])&&isset($_GET['f'])&&isset($_GET['v'])){
	if($_GET['i'] != "new"){
		$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");
		$query = "UPDATE projects_sfw SET ".$_GET['f']."='".$_GET['v']."' WHERE ies_num='".$_GET['i']."'";
		pg_query($conn,$query) or die("Could not execute query: $query");
		pg_close($conn);
	}else{
		$_SESSION['new'][$_GET['f']] = $_GET['v'];
	}
}
?>
