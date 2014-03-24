<?php 
@session_start();

$grant_access=0;
if(isset($_COOKIE['userLevel'])){
  if($_COOKIE['userLevel'] >= 1){
    $grant_access = 1;
  }
}
if($grant_access == 0){
  pg_close($conn);
  header("Location: http://ies.myvnc.com:2200");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/index.css">
    <script src="/scripts/main.js"></script>
    <title>~~ ::IES::SOFTWARE ~~</title>
  </head>
  <body onload="loadUser(); filter();">
    <div class="span_12 row">
      <div class="span_1 col spacer"></div>
        <div id="wrapper" class="col span_10">
          <header id="top">
            <?php include "../../header.php"; ?>
          </header>
          <section id="sections" class="span_12 row">
            <div class="span_12 col">
              <section class="whole" id="content">
                <section id="headerLinks">
                  <div>
                    <ul>
                      <li><a class="headerLink" href="#" onclick="event.preventDefault(); fillFilter('<?php echo $_COOKIE['usersvn'] ?>','engineer',0,0)">Mine</a></li>
                      <li><a class="headerLink" href="#" onclick="event.preventDefault(); fillFilter('','ies_num',0,0)">Active</a></li>
                      <li><a class="headerLink" href="#" onclick="event.preventDefault(); fillFilter('','ies_num',0,1)">Archive</a></li>
                      <li><a class="headerLink" href="utilities.php">Utilities</a></li>
                    </ul>
                  </div>
                </section>
                <section id="searchBox">
                  <select class="filterSearch" name="fType" id="fTypeSelect" onchange="filter(document.getElementById('fIESnumSelect').value,this.value)">
                    <option value="ies_num" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="ies_num"){echo "selected";}}else{echo "selected";}?>>IES Number</option>
                    <option value="name" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="name"){echo "selected";}}?>>Name</option>
                    <option value="customer" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="customer"){echo "selected";}}?>>Customer</option>
                    <option value="engineer" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="engineer"){echo "selected";}}?>>Engineer</option>
                    <option value="notes" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="notes"){echo "selected";}}?>>Notes</option>
                  </select>
                  <input type="text" name="IESnum"  class="filterSearch" id="fIESnumSelect" value="<?php if(isset($_SESSION['fIESnum'])){echo $_SESSION['fIESnum'];}?>" onkeyup="filter(this.value,document.getElementById('fTypeSelect').value)" autocomplete="off"/>
                </section>
                <section id="projectsTable">
                </section>
              </section>
            </div>
          </section>
        <div class="span_12 row">
          <div class="span_12 col">
            <footer>
              <?php include "../../footer.html"; ?>
            </footer>
          </div>
        </div>
      <div id="footerspace"></div>
    </div>
  </body>
</html>
