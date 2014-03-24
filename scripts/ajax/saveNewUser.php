<?php
$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin");
@session_start();

// begin Recordset
$query = "SELECT * FROM users_usr WHERE level_usr>0 ORDER BY lname_usr ASC";
$_SESSION['acct_update_refresh'] = $_SERVER['PHP_SELF'];
$usersRs = pg_query($conn,$query);
$userInfo = array();
$i = 0;
while($newUser = pg_fetch_assoc($usersRs)){
  $userInfo[$i]['fname_usr'] = $newUser['fname_usr'];
  $userInfo[$i]['lname_usr'] = $newUser['lname_usr'];
}
// end Recordset


if(isset($_SESSION['fname_usr']) && isset($_SESSION['lname_usr']) && isset($_SESSION['conum_usr'])){
  foreach($userInfo as $user){
    if((($user['fname_usr'] == $_SESSION['fname_usr']) && ($user['lname_usr'] == $_SESSION['lname_usr'])) || ($user['conum_usr'] == $_SESSION['conum_usr'])){
      pg_close($conn);
      exit;
    }
  }
  $query = "INSERT INTO users_usr (fname_usr, lname_usr, conum_usr, pass_usr, title_usr, dept_usr, email_usr, level_usr, reports_to";
  if(isset($_SESSION['usrname_usr'])){
    $query .= ", usrname_usr";
  }
  if(isset($_SESSION['svn_usr'])){
    $query .= ", svn_usr";
  }
  $query .= ") values('".$_SESSION['fname_usr']."', '".$_SESSION['lname_usr']."', ".$_SESSION['conum_usr'].", '".$_SESSION['pass_usr']."', '".$_SESSION['title_usr']."', ".$_SESSION['dept_usr'].", '".$_SESSION['email_usr']."', ".$_SESSION['level_usr'].", '".$_SESSION['reports_to'];
  if(isset($_SESSION['usrname_usr'])){
    $query .= ", '".$_SESSION['usrname_usr']."'";
  }
  if(isset($_SESSION['svn_usr'])){
    $query .= ", '".$_SESSION['svn_usr']."'";
  }
  $query .= ")";

  pg_query($conn,$query) or die("Could not execute query: $query");
  $query = "SELECT id_usr FROM users_usr WHERE fname_usr='".$_SESSION['fname_usr']."' AND lname_usr='".$_SESSION['lname_usr']."'";
  $rs = pg_query($conn,$query) or die("Could not execute query: $query");
  $result = pg_fetch_assoc($rs);
  setcookie('lastUser',$result['id_usr'],time()+60*60,'/');
}
pg_close($conn);
?>
