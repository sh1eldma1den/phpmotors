<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
  phpmotorsConnect();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login | PHP Motors</title>
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
        <h1 class="formHeader">Log in to your account</h1>
        <div class="classDiv">
        <?php
          if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
          }
        ?> 
        <?php
              if (isset($message)) {
                echo $message;
              }
        ?> 
            <form method="post" action="/phpmotors/accounts/" id="loginForm">
                <fieldset class="fieldset">  
                    <legend class="formLegend">All fields required</legend>
                    <label class="email fieldsetLabel">User Email:
                      <input type="email" name="clientEmail" id="clientEmail" required placeholder="johnjohnson@email.com"
                        <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
                      />
                    </label>
                    <label class="clientPassword fieldsetLabel">Password:
                      <span class="notice"><p>Passwords must be at least 8 characters and contain at least 1 number,
                         1 capital letter and 1 special character.</p></span>
                      <input type="password" name="clientPassword" id="clientPassword"
                      required pattern="/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/"/>
                    </label>
                    <input type="submit" class="submitBtn" value="Login">
                    <input type="hidden" name="action" value="loginSubmit"><br><br>
                    <div id="registrationLink"><h2>No account? <a href="/phpmotors/accounts/index.php?action=register">Sign up</a></h2></div>
                </fieldset> 
            </form>
        </div>
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>