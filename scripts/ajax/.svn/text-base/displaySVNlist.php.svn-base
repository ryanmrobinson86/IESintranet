<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
@session_start();

$thisProjectSVNlist = Array();
if($_GET['i'] != 'new'){
	$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

	$query = "SELECT svn_dir FROM projects_sfw WHERE ies_num='".$_GET['i']."'";
	$rs = pg_query($conn,$query) or die("Could not execute query: $query");
	$temparray = pg_fetch_assoc($rs);
	if(strlen($temparray['svn_dir'])){
		$thisProjectSVNlist = explode(",",$temparray['svn_dir']);
	} else {
		unset($thiProjectSVNlist);
	}
}else if(isset($_SESSION['new']['svn_dir'])){
	$thisProjectSVNlist = $_SESSION['new']['svn_dir'];
}

$j=0;
if(isset($thisProjectSVNlist)){
	for($j=0;$j<count($thisProjectSVNlist);$j++){
		if($j != $_GET['s']){?>
			<a id="svn<?php echo $j.$_GET['i'] ?>" class="nowrapDiv projectEditField" href="http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisProjectSVNlist[$j] ?>" onclick="editProjectFieldSVN(this,'<?php echo $_GET['i'].'\','.$j ?>,event)">http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisProjectSVNlist[$j] ?></a><br>
		<?php } else {?>
			<span>http://<?php echo $_SERVER['HTTP_HOST']?>/svn/</span><input type="text" id="svn<?php echo $j.$_GET['i'] ?>" class="nowrapDiv projectEditField SVN" value="<?php echo $thisProjectSVNlist[$j] ?>" onblur="saveProjectFieldSVN(this,'<?php echo $_GET['i']."',".$j ?>)" onkeydown="validateEditProjectEnter(this,event)"></input><br>
		<?php }
	}
}
if($j == $_GET['s']){ ?>
	<span>http://<?php echo $_SERVER['HTTP_HOST']?>/svn/</span><input type="text" id="svn<?php echo $j.$_GET['i'] ?>" class="nowrapDiv projectEditField SVN" placeholder="SVN folder" onblur="saveProjectFieldSVN(this,'<?php echo $_GET['i']."',".$j ?>)" onkeydown="validateEditProjectEnter(this,event)"></input>
<?php } ?>
