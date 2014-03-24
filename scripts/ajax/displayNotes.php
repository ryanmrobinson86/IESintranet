<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);

@session_start();

$project = Array();
if(isset($_GET['i'])){
	if($_GET['i'] != 'new'){
		$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

		$rs = pg_query($conn,"SELECT notes FROM projects_sfw WHERE ies_num='".$_GET['i']."'") or die("Could not execute query");

		$project = pg_fetch_assoc($rs);
		pg_close($conn);
	} else if(isset($_SESSION['new']['notes'])){
		$project = $_SESSION['new'];
	} else {
		$_SESSION['new']['notes'] = "";
		$project = $_SESSION['new'];
	}?>


	<textarea id="notes<?php echo $_GET['i'] ?>" class="projectEditField" onkeyup="setTextAreaHeight(this)" onkeydown="setTextAreaHeight(this)" onblur="saveProjectFieldNotes(this,'<?php echo $_GET['i'] ?>')"><?php echo $project['notes'] ?></textarea>

<?php }?>
