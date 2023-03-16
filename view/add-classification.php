<?php
  if ($_SESSION['loggedin'] !== TRUE AND $_SESSION['clientData']['clientLevel'] == 1) {
    header('Location: /phpmotors/index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Add a Vehicle Classification | PHP Motors</title>
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
        <h1>Add a new vehicle classification</h1>
        <?php
              if (isset($message)) {
                echo $message;
              }
        ?>
        <form method="post" action="/phpmotors/vehicles/index.php" id="addClassification">
          <fieldset class="fieldset">  
            <legend>All fields required</legend>
            <label class="fieldsetLabel">New Classification:
              <span class="notice"><p>Classification names are limited to 30 characters.</p></span>
              <input type="text" name="classificationName" id="classificationName" placeholder="Batmobile" 
                required pattern="[A-Za-z0-9_]{1,30}"
              />
            </label>
            <input type="submit" class="submitBtn" value="Add"/>
            <input type="hidden" name="action" value="classSubmit"/>
          </fieldset>
        </form>  
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>