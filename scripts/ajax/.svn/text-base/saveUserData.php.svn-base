<?php
$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin");
@session_start();

$field = 0;
if(isset($_GET['f'])){
  if($_GET['f'] == 'lnameValue'){
    $field = 'lname_usr';
  }
  if($_GET['f'] == 'fnameValue'){
    $field = 'fname_usr';
  }
  if($_GET['f'] == 'coNumValue'){
    $field = 'conum_usr';
  }
  if($_GET['f'] == 'usernameValue'){
    $field = 'usrname_usr';
  }
  if($_GET['f'] == 'passwordValue'){
    $field = 'pass_usr';
  }
  if($_GET['f'] == 'titleValue'){
    $field = 'title_usr';
  }
  if($_GET['f'] == 'deptValue'){
    $field = 'dept_usr';
  }
  if($_GET['f'] == 'svnValue'){
    $field = 'svn_usr';
  }
  if($_GET['f'] == 'emailValue'){
    $field = 'email_usr';
  }
  if($_GET['f'] == 'levelValue'){
    $field = 'level_usr';
  }
  if($_GET['f'] == 'bossValue'){
    $field = 'reports_to';
  }
}

if(isset($_GET['i'])){
  $query = "UPDATE users_usr SET $field='".$_GET['v']."' WHERE id_usr=".$_GET['i'];
  pg_query($conn,$query) or die("Could not execute query: $query");
}else{
  $_SESSION[$field] = $_GET['v'];
}
pg_close($conn);

if(isset($_GET['f'])){
  if($_GET['f'] == 'lnameValue'){ ?>
  <?php } else if($_GET['f'] == 'fnameValue'){?>
  <?php } else if($_GET['f'] == 'coNumValue'){?>
  <?php } else if($_GET['f'] == 'usernameValue'){?>
  <?php } else if($_GET['f'] == 'passwordValue'){?>
  <?php } else if($_GET['f'] == 'titleValue'){?>
  <?php } else if($_GET['f'] == 'deptValue'){?>
  <?php } else if($_GET['f'] == 'svnValue'){?>
  <?php } else if($_GET['f'] == 'emailValue'){?>
  <?php } else if($_GET['f'] == 'levelValue'){?>
  <?php } else if($_GET['f'] == 'bossValue'){?>
    <span class="userValue" onclick="spanToBossSelect(this,<?php echo $user['id_usr']; ?>)"><?php echo $_GET['v'] ?></span>
  <?php }?>
