<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Inventory Search | PHP Motors</title>
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
        <h1>Search our inventory</h1>
        <?php 
            if(isset($message)){
                echo $message; 
            }
        ?>
        <form method="post" action="/phpmotors/search/index.php">
            <label>No special characters allowed.
            <input type="text" name="searchStr" id="searchStr" required
            <?php if(isset($searchStr)){echo "value='$searchStr'";}  ?>></label>
            <input type="submit" class="searchBtn" value="Search"/>
            <input type="hidden" name="action" value="searchSubmit"/>
        </form>
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>