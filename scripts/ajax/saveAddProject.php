<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);

@session_start();

$engineerStr = '';
if(isset($_SESSION['new']['engineer'])){
	$i = 0;
	for($i=0;$i<count($_SESSION['new']['engineer'])-1;$i++){
		$engineerStr .= $_SESSION['new']['engineer'][$i].",";
	}
	if(count($_SESSION['new']['engineer'])){
		$engineerStr .= $_SESSION['new']['engineer'][$i];
	}
}

$SVNstr = '';
if(isset($_SESSION['new']['svn_dir'])){
	$i = 0;
	for($i=0;$i<count($_SESSION['new']['svn_dir'])-1;$i++){
		$SVNstr .= $_SESSION['new']['svn_dir'][$i].",";
	}
	if(count($_SESSION['new']['svn_dir'])){
		$SVNstr .= $_SESSION['new']['svn_dir'][$i];
	}
}

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");
if(isset($_SESSION['new']['ies_num'])){
	$query = "SELECT * FROM projects_sfw WHERE ies_num='".$_SESSION['new']['ies_num']."'";
	$rs = pg_query($conn,$query) or die("Could not execute query: $query");
	$rows = pg_num_rows($rs);
	if($rows){
		$query = "UPDATE projects_sfw SET archive=0 WHERE ies_num='".$_SESSION['new']['ies_num']."'";
		pg_query($conn,$query) or die("Could not execute query: $query");
		$dont_run = 1;
	}
	unset($_SESSION['new']);
}
if(isset($_SESSION['new']['ies_num']) && isset($_SESSION['new']['name']) && isset($_SESSION['new']['customer'])){
	$query = "INSERT INTO projects_sfw (ies_num, name, customer";
	if(isset($_SESSION['new']['engineer'])){
		$query .= ", engineer";
	}
	if(isset($_SESSION['new']['svn_dir'])){
		$query .= ", svn_dir";
	}
	if(isset($_SESSION['new']['notes'])){
		$query .= ", notes";
	}
	$query .= ") values('".$_SESSION['new']['ies_num']."', '".$_SESSION['new']['name']."', '".$_SESSION['new']['customer']."'";
	if(isset($_SESSION['new']['engineer'])){
		$query .= ", '".$engineerStr."'";
	}
	if(isset($_SESSION['new']['svn_dir'])){
		$query .= ", '".$SVNstr."'";
	}
	if(isset($_SESSION['new']['notes'])){
		$query .= ", '".$_SESSION['new']['notes']."'";
	}
	$query .= ")";
	pg_query($conn,$query) or die("Could not execute query: $query");
}
pg_close($conn);
?>
