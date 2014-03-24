<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
@session_start();

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

$query = "SELECT conum_usr, fname_usr, lname_usr, svn_usr FROM users_usr WHERE level_usr>0 AND svn_usr NOT LIKE '' ORDER BY lname_usr ASC";
$rs = pg_query($conn,$query) or die("Could not execute query: $query");
$enginnersArray = array();
$i=0;
while($temparray = pg_fetch_assoc($rs)){
  if(strlen($temparray['svn_usr'])){
    $engineersArray[$i]['fName'] = $temparray['fname_usr'];
    $engineersArray[$i]['lName'] = $temparray['lname_usr'];
    $engineersArray[$i]['svnName'] = $temparray['svn_usr'];
    $engineersArray[$i++]['dispName'] = $temparray['fname_usr']." ".$temparray['lname_usr'];
  }
}

$thisProjectEngineer = Array();
if($_GET['i'] != 'new'){
	$query = "SELECT engineer FROM projects_sfw WHERE ies_num='".$_GET['i']."'";
	$rs = pg_query($conn,$query) or die("Could not execute query: $query");
	$temparray = pg_fetch_assoc($rs);
	$thisProjectEngineer = explode(",",$temparray['engineer']);
}else if(isset($_SESSION['new']['engineer'])){
	$thisProjectEngineer = $_SESSION['new']['engineer'];
}

for($j=0;$j<count($thisProjectEngineer);$j++){
	foreach($engineersArray as $thisEngineer){
		if(($thisEngineer['svnName'] === $thisProjectEngineer[$j])&&($j != $_GET['e'])){?>
			<div id="engineer<?php echo $j.$_GET['i'] ?>" value= "<?php echo $thisEngineer['svnName']?>" class="nowrapDiv projectEditField" onclick="editProjectFieldEngineer(this,'<?php echo $_GET['i'].'\','.$j ?>)">
				<?php echo $thisEngineer['dispName']."<br>";?>
			</div>
		<?php }
		else if(($thisEngineer['svnName'] === $thisProjectEngineer[$j])&&($j == $_GET['e'])){?>
			<select id="engineer<?php echo $j.$_GET['i'] ?>" class="projectEditField" onblur="saveProjectFieldEngineer(this,'<?php echo $_GET['i']."',".$_GET['e'].",".count($thisProjectEngineer) ?>)" onkeydown="validateEditProjectEnter(this,event)">
				<option value="blank"></option>
				<?php foreach($engineersArray as $thisEngineer){ ?>
					<option value="<?php echo $thisEngineer['svnName'] ?>" <?php if($thisProjectEngineer[$_GET['e']] == $thisEngineer['svnName']){echo "selected";}?>><?php echo $thisEngineer['dispName'] ?></option>
				<?php } ?>
			</select>
		<?php }
	}
}
if($j != $_GET['e']){?>
	<div id="engineer<?php echo $j.$_GET['i'] ?>" class="nowrapDiv projectEditField newProjectValue" onclick="editProjectFieldEngineer(this,'<?php echo $_GET['i'].'\','.$j ?>)">...New...</div>
<?php }else{?>
	<select id="engineer<?php echo $j.$_GET['i'] ?>" class="projectEditField newProjectValue" onblur="saveProjectFieldEngineer(this,'<?php echo $_GET['i']."',".$_GET['e'].",".count($thisProjectEngineer) ?>)" onkeydown="validateEditProjectEnter(this,event)">
		<option value="blank"></option>
		<?php foreach($engineersArray as $thisEngineer){ ?>
			<option value="<?php echo $thisEngineer['svnName'] ?>" <?php if($thisProjectEngineer[$_GET['e']] == $thisEngineer['svnName']){echo "selected";}?>><?php echo $thisEngineer['dispName'] ?></option>
		<?php } ?>
	</select>
<?php } ?>
