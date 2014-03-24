<?php
ini_set('display_errors','On');
$uName=$_POST["uName"];
$pwd=$_POST["pwd"];
$cPwd=$_POST["cPwd"];
$oPwd=$_POST["oPwd"];

$output = "";
$changed=false;
$htdigest="/var/www/utilities/digestfile.dgst";
$in = fopen($htdigest,'r');
$exit = 0;
while(preg_match("/:/",$line = fgets($in)))
	{
	$line = rtrim($line);
	$a = explode(':',$line);
	if($a[0]==$uName && $a[1]=="SVN")
		{
		if($a[2] != md5("$uName:SVN:$oPwd"))
			{
			echo "Incorrect Password! Password not changed";
			$exit = 1;
			}
		else if($pwd===$cPwd)
			{
			$a[2] = md5("$uName:SVN:$pwd");
			$changed = true;
			}
		else
			{
			echo "Passwords do not match!! Password not changed";
			$exit = 1;
			}
		}
	if($exit==0)
		{
		$output .= implode(':',$a)."\n";
		}
	}
fclose($in);
if(!$changed && !$exit)
	{
	$prompt = "User does not exist!! No password created<br>";
	$prompt = $prompt."Contact Mark Brucoli or Ryan Robinson to create user ".$uName.".";
	echo $prompt;
	$exit = 1;
	}
if(!$exit)
	{
	$out = fopen("$htdigest.new",'w');
	fwrite($out,$output);
	fclose($out);
	system("mv -f $htdigest.new $htdigest");
	echo "Password successfully changed";
	}
?>
<html>
<body>
</br><a href="index.php">Return</a>
</body>
</html>
