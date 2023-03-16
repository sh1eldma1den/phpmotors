<?php
  if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
  }
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Vehicle Management | PHP Motors</title>
    <!-- device-width is the width of the screen in CSS pixels -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- screen is used for computer screens, tablets, smart-phones etc. -->
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    <link href="/phpmotors/css/normalize.css" type="text/css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div id="wrapper">
      <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/header.php" ?>
      </header>
      <nav>
        <?php echo $navList; ?>
      </nav>
      <main>
        <h1>Vehicle Management</h1>
      <p><a href="/phpmotors/vehicles/index.php?action=add-classification">Add a Classification</a><br><br><br>
      <a href="/phpmotors/vehicles/index.php?action=add-vehicle">Add a Vehicle to Inventory</a>
      <?php
        if (isset($_SESSION['message'])) { 
          echo $message; 
        } 
        if (isset($classificationList)) { 
          echo '<h2>Vehicles By Classification</h2>'; 
          echo '<p>Choose a classification to see those vehicles</p>'; 
          echo $classificationList; 
        }
      ?>
      <noscript>
        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
      </noscript>
      <table id="inventoryDisplay"></table>
  </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
    <script src="/phpmotors/js/inventory.js"></script>
  </body>
</html>
<?php unset($_SESSION['message']); ?>