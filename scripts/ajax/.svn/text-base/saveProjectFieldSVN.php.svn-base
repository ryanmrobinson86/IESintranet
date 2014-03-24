<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
@session_start();

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

$projectTable = strval($_COOKIE['username'])."projectTable";

// check that the engineer is only added once
if($_GET['i'] != 'new'){
	if(isset($_SESSION[$projectTable][$_GET['i']]['svn_dir'])){
		foreach($_SESSION[$projectTable][$_GET['i']]['svn_dir'] as $this_svn){
			if($this_svn == $_GET['v']){
				unset($_GET['v']);
				break;
			}
		}
	}
}else{
	if(isset($_SESSION['new']['svn_dir'])){
		foreach($_SESSION['new']['svn_dir'] as $this_svn){
			if($this_svn == $_GET['v']){
				unset($_GET['v']);
				break;
			}
		}
	}
}

if(isset($_GET['v'])&&isset($_GET['i'])&&isset($_GET['s'])){
	if($_GET['i'] != 'new'){
		if($_GET['v'] != 'blank'){
			$_SESSION[$projectTable][$_GET['i']]['svn_dir'][$_GET['s']] = $_GET['v'];
		}else{
			if(isset($_SESSION[$projectTable][$_GET['i']]['svn_dir'])){
				for($i=$_GET['s'];$i<count($_SESSION[$projectTable][$_GET['i']]['svn_dir'])-1;$i++){
					$_SESSION[$projectTable][$_GET['i']]['svn_dir'][$i] = $_SESSION[$projectTable][$_GET['i']]['svn_dir'][$i+1];
				}
				unset($_SESSION[$projectTable][$_GET['i']]['svn_dir'][$i]);
			}
		}
		if(isset($_SESSION[$projectTable][$_GET['i']]['svn_dir'])){
			$output = implode(",",$_SESSION[$projectTable][$_GET['i']]['svn_dir']);

			$query = "UPDATE projects_sfw SET svn_dir='".$output."' WHERE ies_num='".$_GET['i']."'";
			pg_query($conn,$query) or die("Could not execute query: $query");
		}
	}else{
		if($_GET['v'] != 'blank'){
			$_SESSION['new']['svn_dir'][$_GET['s']] = $_GET['v'];
		}else{
			if(isset($_SESSION['new']['svn_dir'])){
				for($i=$_GET['s'];$i<count($_SESSION['new']['svn_dir'])-1;$i++){
					$_SESSION['new']['svn_dir'][$i] = $_SESSION['new']['svn_dir'][$i+1];
				}
				unset($_SESSION['new']['svn_dir'][$i]);
			}
		}
	}
}

$thisProjectSVNlist = array();
if($_GET['i'] != 'new'){
	$query = "SELECT svn_dir FROM projects_sfw WHERE ies_num='".$_GET['i']."'";
	$rs = pg_query($conn,$query) or die("Could not execute query: $query");
	$temparray = pg_fetch_assoc($rs);

	if(strlen($temparray['svn_dir'])){
		$thisProjectSVNlist = explode(",",$temparray['svn_dir']);
	} else {
		unset($thisProjectSVNlist);
	}
}else if(isset($_SESSION['new']['svn_dir'])){
	$thisProjectSVNlist = $_SESSION['new']['svn_dir'];
}

$j=0;
if(isset($thisProjectSVNlist)){
	foreach($thisProjectSVNlist as $thisDir){ ?>
		<a id="svn<?php echo $j++.$_GET['i'] ?>" class="nowrapDiv projectEditField" href="http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisDir ?>" onclick="editProjectFieldSVN(this,'<?php echo $_GET['i']?>',<?php echo($j-1) ?>,event)">http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisDir ?></a>
	<?php }
} ?>
<div id="svn<?php echo $j++.$_GET['i'] ?>" class="nowrapDiv projectEditField newProjectValue" onclick="editProjectFieldSVN(this,'<?php echo $_GET['i']?>',<?php echo($j-1) ?>,event)">...New...</div>
