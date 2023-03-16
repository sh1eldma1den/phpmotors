<?php
    if ($_SESSION['loggedin'] !== TRUE){
        header('Location: /phpmotors/index.php');
    }
    if($_SESSION['clientData']['clientLevel'] == 3) {
      $message = "<div id='admin-message'>
                <div class='manage-div'><h2>Vehicle Management Portal</h2><br>
                <p>Click here to enter the Vehicles Management Portal to administer inventory.<br><br>
                <a href='/phpmotors/vehicles' title='Enter Vehicle Management Portal'>Vehicle Management Portal</a></p></div>
                <div class='manage-div'><h2>Images Management Portal</h2><br>
                <p>Click here to enter the Images Management Portal to administer inventory images.<br><br>
                <a href='/phpmotors/uploads' title='Enter Image Management Portal'>Image Management Portal</a></p></div>
                </div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My Account | PHP Motors</title>
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
        <h1><?php echo " Welcome, " . $_SESSION['clientData']['clientFirstname'] . " 
            " . $_SESSION['clientData']['clientLastname'] . "! You are logged in." ?>
        </h1>
          <p>
        <?php
            echo "First name: " . $_SESSION['clientData']['clientFirstname'] . "<br>";
            echo "Last name: " . $_SESSION['clientData']['clientLastname'] . "<br>";
            echo "Email address: " . $_SESSION['clientData']['clientEmail'] . "<br><br>";
            // Link to the upate the user's account information
            echo "Click here to update your account information. 
              <a href='/phpmotors/accounts/index.php?action=updateAccount' title='Update your PHP Motors account information' id='actionButton'>Update my information</a><br><br>";
            // if client is above level 3, access to vehicle management will appear below.
            if (isset($message)) { 
            echo $message; 
          }
          
        ?>  
   
        </p>
         </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>
<?php unset($_SESSION['message']); ?>