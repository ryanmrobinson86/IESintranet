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
    <meta charset="UTF-8"> <link rel="stylesheet" href="/style/index.css">
    <script src="/scripts/main.js"></script>
    <title>~~ ::IES::SOFTWARE ~~</title>
  </head>
  <body onload="loadUser()">
    <div class="span_12 row">
      <div class="span_1 col spacer"></div>
      <div id="wrapper" class="col span_10">
        <header id="top">
          <?php include "../../header.php"; ?>
        </header>
        <section id="sections" class="span_12 row">
          <section class="whole" id="content">
            <section id="headerLinks">
              <ul>
                <li><a class="headerLink" href="index.php">Projects</a></li>
              </ul>
            </section>
            <section>
              <ul>
                <li class="action"><a href="changePwd.html">Update SVN Password</a></li>
                <li class="action"><a href="addNewProject.html">Add New SVN Project</a></li>
              </ul>
            </section>
            <section id="utils">
            </section>
          </section>
        </section>
        <footer>
          <?php include "../../footer.html"; ?>
        </footer>
        <div id="footerspace"></div>
      </div>
    </div>
  </body>
</html>
