<?php
ini_set('display_errors','On');
error_reporting(E_ALL|E_STRICT);
$refresh = "/dept/software/";

@session_start();

$refresh = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$conn = pg_connect("host=localhost dbname=IES_Systems user=IESAdmin password=admin") or die("Could not Connect to DB\n");

$query = "SELECT fname_usr, lname_usr, svn_usr FROM users_usr WHERE level_usr>0 AND svn_usr NOT LIKE ''";
$rs = pg_query($conn,$query) or die("Could not execute query: $query");
$enginners_arr = array();
$i=0;
while($temparray = pg_fetch_assoc($rs)){
  $engineers_arr[$i]['fName'] = $temparray['fname_usr'];
  $engineers_arr[$i]['lName'] = $temparray['lname_usr'];
  $engineers_arr[$i]['svnName'] = $temparray['svn_usr'];
  $engineers_arr[$i++]['dispName'] = $temparray['fname_usr']." ".$temparray['lname_usr'];
}

if(isset($_GET['n'])||isset($_GET['t'])||isset($_GET['e'])){
  $refresh .= "?";
}

//gather the data to display in the table
if(isset($_GET['n'])){
  $_SESSION['fIESnum'] = $_GET['n'];
  $refresh .= "n=".$_GET['n'];
  if(isset($_GET['t'])||isset($_GET['e'])){
    $refresh .= "&";
  }
}else{
  unset($_SESSION['fIESnum']);
}
if(isset($_GET['t'])){
  $_SESSION['fType'] = $_GET['t'];
  $refresh .= "t=".$_GET['t'];
  if(isset($_GET['e'])){
    $refresh .= "&";
  }
}else{
  unset($_SESSION['fType']);
}
if(isset($_GET['e'])){
  $_SESSION['editMode'] = $_GET['e'];
  $refresh .= "e=".$_GET['e'];
}
if(isset($_GET['a'])){
  if($_GET['a'] >= 1){
    setcookie('archive',1,time()+60*60*24*30,"/");
    header("Location: $refresh");
  }else{
    setcookie('archive',0,time()-3600,"/");
    header("Location: $refresh");
  }
}
if(!isset($_COOKIE['archive'])){
  if(isset($_SESSION['fIESnum'])){
    $query = "SELECT * FROM projects_sfw WHERE ".$_SESSION['fType']." ILIKE '%".$_SESSION['fIESnum']."%' AND archive != 1 ORDER BY ies_num ASC";
    $rs = pg_query($conn,$query) or die("Could not execute query");
  }else{
    $query = "SELECT * FROM projects_sfw WHERE archive != 1 ORDER BY ies_num ASC";
    $rs = pg_query($conn,$query) or die("Could not execute query");
  }
}else{
  if(isset($_SESSION['fIESnum'])){
    $query = "SELECT * FROM projects_sfw WHERE ".$_SESSION['fType']." ILIKE '%".$_SESSION['fIESnum']."%' AND archive = 1 ORDER BY ies_num ASC";
    $rs = pg_query($conn,$query) or die("Could not execute query");
  }else{
    $query = "SELECT * FROM projects_sfw WHERE archive = 1 ORDER BY ies_num ASC";
    $rs = pg_query($conn,$query) or die("Could not execute query");
  }
}
$projectTable = strval($_COOKIE['username'])."projectTable";
setcookie("projectTable",$projectTable,time()+60*60*24*30,"/");
unset($_SESSION[$projectTable]);
$_SESSION[$projectTable] = array();
while($new_project = pg_fetch_assoc($rs)) {
  $_SESSION[$projectTable][$new_project['ies_num']]['name'] = $new_project['name'];
  $_SESSION[$projectTable][$new_project['ies_num']]['customer'] = $new_project['customer'];
  if(strlen($new_project['engineer'])){
    $temparray = explode(",",$new_project['engineer']);
    $i=0;
    foreach($temparray as $thisowner){
      $_SESSION[$projectTable][$new_project['ies_num']]['engineer'][$i++] = $thisowner;
    }
  }
  if(strlen($new_project['svn_dir'])){
    $temparray = explode(",",$new_project['svn_dir']);
    $i=0;
    foreach($temparray as $thisdir){
      $_SESSION[$projectTable][$new_project['ies_num']]['svn_dir'][$i++] = $thisdir;
    }
  }
  $_SESSION[$projectTable][$new_project['ies_num']]['notes'] = $new_project['notes'];
  $_SESSION[$projectTable][$new_project['ies_num']]['notes'] = nl2br($_SESSION[$projectTable][$new_project['ies_num']]['notes']);
}
if(isset($_SESSION[$projectTable])){
  $project_keys = array_keys($_SESSION[$projectTable]);
}
$query = "SELECT fname_usr, date_time FROM last_edit WHERE last_edit='last_edit'";
$rs = pg_query($conn,$query) or die("Could not execute query: $query");
$lTdata = pg_fetch_assoc($rs);
setcookie("lastTime",$lTdata['date_time'],time()+60*60*24*30,"/");
setcookie("lastFname",$lTdata['fname_usr'],time()+60*60*24*30,"/");

$query = "SELECT timestamp FROM change_list ORDER BY timestamp DESC LIMIT 1";
$rs = pg_query($conn,$query) or die("Could not execute query: $query");
$time = pg_fetch_row($rs);
setcookie("leTimestamp",$time[0],time()+60*60,"/");

pg_close($conn);
if(!isset($_COOKIE['archive'])){
  if(isset($_SESSION['editMode'])){
    if($_SESSION['editMode'] == 0){ ?>
      <input type="submit" id="editButton" value="Edit" class="filterButton" name="eButton" onclick="filter(document.getElementById('fIESnumSelect').value,document.getElementById('fTypeSelect').value,1)"/>
<?php } else { ?>
        <input type="submit" value="Done" class="filterButton" name="eButton" onclick="filter(document.getElementById('fIESnumSelect').value,document.getElementById('fTypeSelect').value,0)"/>
        <?php if($_COOKIE['userLevel'] == 15){?>
          <input type="submit" value="Archive Checked" class="filterButton" name="archButton" onclick="archiveAllProjects()"/>
        <?php }
    }
  } else { ?>
    <input type="submit" id="editButton" value="Edit" class="filterButton" name="eButton" onclick="filter(document.getElementById('fIESnumSelect').value,document.getElementById('fTypeSelect').value,1)"/>
  <?php }
  if($_COOKIE['userLevel'] == 15){ 
    if(isset($_SESSION['editMode'])){
      if($_SESSION['editMode'] == 0){?>
        <input type="submit" id="addButton" value="Add" class="filterButton" name="aButton" onclick="addProject()"/>
      <?php }
    } else {?>
      <input type="submit" id="addButton" value="Add" class="filterButton" name="aButton" onclick="addProject()"/>
    <?php }
  }
}
if(count($_SESSION[$projectTable]) > 0){
  $i=0;?>
  <table id="projectTable">
    <tr>
      <th class="col1">IES Number</th>
      <th class="col2">Name</th>
      <th class="col3">Customer</th>
      <th class="col4" class="engineerCell">Engineer</th>
      <th class="col5">SVN URL</th>
      <th class="col6">Notes</th>
    </tr>
    <?php foreach($_SESSION[$projectTable] as $thisProject){
      $edit = 0;
      if(isset($_SESSION['editMode'])){
        if($_SESSION['editMode'] == 1){
          if(isset($_COOKIE['userLevel'])){
            if($_COOKIE['userLevel'] == 15){
              $edit = 1;
            }else{
              if(isset($thisProject['engineer'])){
                for($j=0;$j<count($thisProject['engineer']);$j++){
                  if(isset($_COOKIE['usersvn'])){
                    if($thisProject['engineer'][$j] === $_COOKIE['usersvn']){
                      $edit = 1;
                    }
                  }
                }
              }
            }
          }
        }
      }?>
      <tr>
        <td class="col1">
          <div>
            <?php if(($edit==1)&&($_COOKIE['userLevel']==15)){
              echo '<input class="archiveCheckbox" type="checkbox" value="'.$project_keys[$i].'"/>';
            }
            echo $project_keys[$i++] ?>
          </div>
        </td>
        <td class="col2">
          <div id="name<?php echo $project_keys[$i-1] ?>"
            <?php if($edit == 1){
              echo 'class="projectEditField"';
              echo 'onclick="editProjectFieldInput(this,\''.$project_keys[$i-1].'\',\'name\')"';
            } ?>><?php echo $thisProject['name']?></div>
        </td>
        <td class="col3">
          <div id="customer<?php echo $project_keys[$i-1] ?>"
            <?php if($edit == 1){
              echo 'class="projectEditField"';
              echo 'onclick="editProjectFieldInput(this,\''.$project_keys[$i-1].'\',\'customer\')"';
            } ?>><?php echo $thisProject['customer']?></div>
        </td>
        <td class="engineerCell col4">
          <?php if(isset($thisProject['engineer'])){
            for($j=0;$j<count($thisProject['engineer']);$j++){ ?>
              <?php foreach($engineers_arr as $thisEngineer){
                if($thisEngineer['svnName'] === $thisProject['engineer'][$j]){?>
                  <div id="engineer<?php echo $j.$project_keys[$i-1] ?>" value= "<?php echo $thisEngineer['svnName']?>" class="nowrapDiv
                    <?php if($edit == 1){
                      echo 'projectEditField';
                    } ?>" 
                    <?php if($edit == 1){
                      echo 'onclick="editProjectFieldEngineer(this,\''.$project_keys[$i-1].'\','.$j.')"';
                    } else {
                      echo 'onclick="filter(\''.$thisEngineer['svnName'].'\',\'engineer\',0,0)"';
                    }?>>
                    <?php echo $thisEngineer['dispName']."<br>";?>
                  </div>
                <?php }
              }
            }
          }
          if($edit == 1){ ?>
            <div id="engineer<?php echo $j.$project_keys[$i-1] ?>" class="nowrapDiv projectEditField newProjectValue" onclick="editProjectFieldEngineer(this,'<?php echo $project_keys[$i-1].'\','.$j ?>)">
              ...New...
            </div>
          <?php } ?>
        </td>
        <td class="col5">
          <?php
          $j=0;
           if(isset($thisProject['svn_dir'])){
            foreach($thisProject['svn_dir'] as $thisDir){
              if($edit == 1){ ?>
                <div id="svn<?php echo $j++.$project_keys[$i-1] ?>" class="nowrapDiv projectEditField" onclick="editProjectFieldSVN(this,'<?php echo $project_keys[$i-1].'\','.($j-1) ?>,event)">
                  http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisDir ?>
                </div>
              <?php } else { ?>
                <a id="svn<?php echo $j++.$project_keys[$i-1] ?>" class="nowrapDiv" href="http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisDir ?>">
                  http://<?php echo $_SERVER['HTTP_HOST']."/svn/".$thisDir ?>
                </a>
              <?php }
            }
          } 
          if($edit == 1){ ?>
            <div id="svn<?php echo $j++.$project_keys[$i-1] ?>" class="nowrapDiv projectEditField newProjectValue" onclick="editProjectFieldSVN(this,'<?php echo $project_keys[$i-1].'\','.($j-1) ?>,event)">
              ...New...
            </div>
          <?php } ?>
        </td>
        <td class="col6">
          <div id="notes<?php echo $project_keys[$i-1] ?>"
            <?php if($edit == 1){
              echo 'class="projectEditField"';
              echo 'onclick="editProjectFieldNotes(this,\''.$project_keys[$i-1].'\')"';
            } ?>>
            <?php echo $thisProject['notes'] ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </table>
<?php } ?>
