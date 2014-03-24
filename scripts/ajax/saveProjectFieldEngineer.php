<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
$refresh = "/department/software/index.php?sw_main=main";

@session_start();

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

$query = "SELECT fname_usr, lname_usr, svn_usr FROM users_usr WHERE level_usr>0 AND svn_usr NOT LIKE ''";
$rs = pg_query($conn,$query) or die("Could not execute query: $query");
$enginners_arr = array();
$i=0;
while($temparray = pg_fetch_assoc($rs)){
  $engineersArray[$i]['fName'] = $temparray['fname_usr'];
  $engineersArray[$i]['lName'] = $temparray['lname_usr'];
  $engineersArray[$i]['svnName'] = $temparray['svn_usr'];
  $engineersArray[$i++]['dispName'] = $temparray['fname_usr']." ".$temparray['lname_usr'];
}

$projectTable = strval($_COOKIE['username'])."projectTable";

// check that the engineer is only added once
if($_GET['i'] != 'new'){
  if(isset($_SESSION[$projectTable][$_GET['i']]['engineer'])){
    foreach($_SESSION[$projectTable][$_GET['i']]['engineer'] as $this_engineer){
      if($this_engineer == $_GET['v']){
        unset($_GET['v']);
        break;
      }
    }
  }
}else{
  if(isset($_SESSION['new']['engineer'])){
    foreach($_SESSION['new']['engineer'] as $this_engineer){
      if($this_engineer == $_GET['v']){
        unset($_GET['v']);
        break;
      }
    }
  }else{
    $_SESSION['new']['engineer'][0] = $_GET['v'];
  }
}

if(isset($_GET['v'])&&isset($_GET['i'])&&isset($_GET['e'])){
  if(isset($_SESSION[$projectTable][$_GET['i']]['engineer'])){
    if($_GET['i'] != 'new'){
      if($_GET['v'] != 'blank'){
        $_SESSION[$projectTable][$_GET['i']]['engineer'][$_GET['e']] = $_GET['v'];
      }else{
        for($i=$_GET['e'];$i<count($_SESSION[$projectTable][$_GET['i']]['engineer'])-1;$i++){
          $_SESSION[$projectTable][$_GET['i']]['engineer'][$i] = $_SESSION[$projectTable][$_GET['i']]['engineer'][$i+1];
        }
        unset($_SESSION[$projectTable][$_GET['i']]['engineer'][$i]);
      }
      $output = implode(",",$_SESSION[$projectTable][$_GET['i']]['engineer']);

      $query = "UPDATE projects_sfw SET engineer='".$output."' WHERE ies_num='".$_GET['i']."'";
      pg_query($conn,$query) or die("Could not execute query: $query");
    }else{
      if($_GET['v'] != 'blank'){
        $_SESSION['new']['engineer'][$_GET['e']] = $_GET['v'];
      }else{
        for($i=$_GET['e'];$i<count($_SESSION['new']['engineer'])-1;$i++){
          $_SESSION['new']['engineer'][$i] = $_SESSION['new']['engineer'][$i+1];
        }
        unset($_SESSION['new']['engineer'][$i]);
      }
    }
  }
}

$thisProjectEngineer = Array();
if($_GET['i'] != 'new'){
  $query = "SELECT engineer FROM projects_sfw WHERE ies_num='".$_GET['i']."'";
  $rs = pg_query($conn,$query) or die("Could not execute query: $query");
  $temparray = pg_fetch_assoc($rs);
  $thisProjectEngineer = explode(",",$temparray['engineer']);
  pg_close($conn);
}else{
  $thisProjectEngineer = $_SESSION['new']['engineer'];
}

for($j=0;$j<count($thisProjectEngineer);$j++){
  foreach($engineersArray as $thisEngineer){
    if($thisEngineer['svnName'] === $thisProjectEngineer[$j]){?>
      <div id="engineer<?php echo $j.$_GET['i'] ?>" value= "<?php echo $thisEngineer['svnName']?>" class="nowrapDiv projectEditField" onclick="editProjectFieldEngineer(this,'<?php echo $_GET['i'].'\','.$j ?>)"><?php echo $thisEngineer['dispName']."<br>";?></div>
    <?php }
  }
}?>
<div id="engineer<?php echo $j.$_GET['i'] ?>" class="nowrapDiv projectEditField newProjectValue" onclick="editProjectFieldEngineer(this,'<?php echo $_GET['i'].'\','.$j ?>)">...New...</div>
