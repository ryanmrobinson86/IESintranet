<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/index.css">
    <script src="scripts/main.js"></script>
    <title>~~ ::IES::MAIN ~~</title>
  </head>
  <body onload="loadUser()">
    <div class="span_12 row">
      <div class="span_1 col spacer"></div>
      <div id="wrapper" class="col span_10">
        <header id="top">
          <?php include "header.php"; ?>
        </header>
        <section id="sections" class="span_12 row">
          <div class="span_4 col">
            <section id="employeeList" class="thirds first">
              <header>IES Employees</header>
              <p>
				<!-- Add employees here perhaps in a ul -->
              </p>
            </section>
          </div>
          <div class="span_4 col">
            <section id="Qquest" class="thirds middle">
              <header>Qquest Tasks</header>
              <!-- Qquest Task list -->
            </section>
          </div>
          <div class="span_4 col">
            <section id="Utilities" class="thirds last">
              <header>Utilities</header>
              <!-- List of utilities such as Outlook setup, phone manuals, etc. -->
            </section>
          </div>
        </section>
        <footer>
            <?php include "footer.html"; ?>
        </footer>
        <div id="footerspace"></div>
      </div>
    </div>
  </body>
</html>
