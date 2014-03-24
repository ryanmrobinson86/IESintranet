<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
@session_start();

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

if(isset($_GET['t'])){
  if($_GET['t'] == 'b'){
    $query = "SELECT fname_usr, lname_usr, id_usr FROM users_usr WHERE level_usr>=15 ORDER BY lname_usr ASC";
    $rs = pg_query($conn,$query) or die("Could not execute query: $query");
    $enginnersArray = array();
    $i=0;
    while($temparray = pg_fetch_assoc($rs)){
      $engineersArray[$i]['dispName'] = $temparray['fname_usr']." ".$temparray['lname_usr'];
      $engineersArray[$i++]['num'] = $temparray['id_usr'];
    }
    
    $boss = 0;
    if(isset($_GET['u'])){
      $query = "SELECT reports_to FROM users_usr WHERE id_usr=".$_GET['u'];
      $rs = pg_query($conn,$query) or die("Could not exectue query: $query");
      while($row = pg_fetch_row($rs)){
        $boss = $row[0];
        ?><script>alert(<?php echo $boss ?>)</script><?php
      }
    }?>
    <select class="userValue" id="bossValue" onblur="bossSelectToSpan(this,<?php if(isset($_GET['u'])){ echo $_GET['u'];}?>)">
      <option value="-1">Self</option>
      <?php for($i=0;$i<count($engineersArray);$i++){?>
        <option value="<?php echo $engineersArray[$i]['num'] ?>" <?php if($boss == $engineersArray[$i]['num']){echo "selected";}?>><?php echo $engineersArray[$i]['dispName'] ?></option>
      <?php }?>
    </select>
  <?php }
}
pg_close($conn);?>
