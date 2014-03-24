<?php
@session_start();

if(isset($_GET['i'])){
	$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");
	$query = "UPDATE projects_sfw SET archive=1 WHERE ies_num='".$_GET['i']."'";
	pg_query($conn,$query) or die("Could not execute query: $query");
	pg_close($conn);
}
?>
