<?php
$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin");
@session_start();

if(isset($_GET['u'])){
	$query = "UPDATE users_usr SET level_usr=0 WHERE id_usr=".$_GET['u'];
	pg_query($conn,$query);
}
pg_close($conn);
?>
