<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);

@session_start();

$project = Array();
if(isset($_POST['i'])&&isset($_POST['v'])){
	$content = preg_replace('/\x85/','...',str_replace("'","''",$_POST['v']));
	if($_POST['i'] != 'new'){
		$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

		$query = "UPDATE projects_sfw SET notes='".$content."' WHERE ies_num='".$_POST['i']."'";
		$rs = pg_query($conn,$query) or die("Could not execute query");

		$rs = pg_query($conn,"SELECT notes FROM projects_sfw WHERE ies_num='".$_POST['i']."'") or die("Could not execute query");

		$project = pg_fetch_assoc($rs);
		$project['notes'] = nl2br($project['notes']);
		pg_close($conn);
	} else {
		$_SESSION['new']['notes'] = $content;
		$project['notes'] = nl2br($_SESSION['new']['notes']);
		
		if($_SESSION['new']['notes'] == ""){
			$project['notes'] = "...New...";
		}
	} ?>

	<div id="notes<?php echo $_POST['i'] ?>" class="projectEditField <?php if($project['notes'] == "...New..."){echo "newProjectValue";} ?>" onclick="editProjectFieldNotes(this,'<?php echo $_POST['i'] ?>')"><?php echo $project['notes'] ?></div>

<?php }?>
