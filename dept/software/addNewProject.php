<?php
ini_set('display_errors','On');
$project = $_GET['pN'];

if(strlen($project)){
  exec("svn mkdir http://localhost:2200/svn/".$project." http://localhost:2200/svn/branches/".$project." -m 'Auto-creating project ".$project."' --username ies_srv --password ies_srv");
  echo "$project added to SVN root and /branches/\n";
}else{
  echo "$project not added, check if it already exists\n";
}
?>
<a href="utilities.php">RETURN</a>
