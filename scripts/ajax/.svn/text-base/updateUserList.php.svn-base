<?php 
$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin");
@session_start();

$grant_access=0;
if(isset($_COOKIE['userLevel'])){
	if($_COOKIE['userLevel'] == 15){
		$grant_access = 1;
	}
}
if($grant_access == 0){
	pg_close($conn);
	header("Location: /");
}
// begin Recordset
$query = "SELECT * FROM users_usr WHERE level_usr>0 ORDER BY lname_usr ASC";
$_SESSION['acct_update_refresh'] = $_SERVER['PHP_SELF'];
$usersRs = pg_query($conn,$query);
$userInfo = array();
$i = 0;
while($newUser = pg_fetch_assoc($usersRs)){
	$userInfo[$i]['id_usr'] = $newUser['id_usr'];
	$userInfo[$i]['username_usr'] = $newUser['username_usr'];
	$userInfo[$i]['fname_usr'] = $newUser['fname_usr'];
	$userInfo[$i]['lname_usr'] = $newUser['lname_usr'];
	$userInfo[$i]['conum_usr'] = $newUser['conum_usr'];
	$userInfo[$i]['pass_usr'] = $newUser['pass_usr'];
	$userInfo[$i]['title_usr'] = $newUser['title_usr'];
	$userInfo[$i]['dept_usr'] = $newUser['dept_usr'];
	$userInfo[$i]['svn_usr'] = $newUser['svn_usr'];
	$userInfo[$i]['email_usr'] = $newUser['email_usr'];
	$userInfo[$i++]['level_usr'] = $newUser['level_usr'];
}
// end Recordset

?>
<header>Users</header>
<ul>
	<li class="action newUser" onclick="showUser()">Add New</li>
<?php foreach($userInfo as $user){?>
	<li class="action" onclick="showUser(<?php echo $user['id_usr']; ?>)"><?php echo $user['lname_usr'].", ".$user['fname_usr']; ?></li>
<?php } ?>
</ul>
