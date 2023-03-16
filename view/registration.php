<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
  phpmotorsConnect();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Register for a New Account | PHP Motors</title>
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
        <h1 class="formHeader">Create a new account with PHP Motors</h1>
        <div class="formDiv">
            <?php
              if (isset($message)) {
                echo $message;
              }
            ?>
            <form method="post" action="/phpmotors/accounts/index.php" id="loginForm">
                <fieldset class="fieldset"> 
                    <legend>All fields required</legend> 
                    <label class="clientFname fieldsetLabel">First name: 
                        <input type="text" name="clientFirstname" id="fname" pattern="[A-Za-z .-]{2,30}"
                         placeholder="John" required
                         <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>/>
                    </label>
                    <label class="clientLname fieldsetLabel">Last name:
                        <input type="text" name="clientLastname" id="lname" pattern="[A-Za-z .-]{2,30}"
                         placeholder="Johnson" required 
                         <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>
                        />
                    </label>
                    <label class="email fieldsetLabel">Email: 
                            <input type="email" name="clientEmail" id="email" placeholder="johnjohnson@email.com"
                            required
                            <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>/>
                        </label>
                    <label class="newClientPw fieldsetLabel">Password: 
                      <span id="pwRequire"><p>Passwords must be at least 8 characters and contain at least 1 number,
                         1 capital letter and 1 special character</p></span>
                        <input type="password" name="clientPassword" id="password" 
                        required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/>
                    </label>
                    <input type="submit" class="submitBtn" value="Register"/>
                    <input type="hidden" name="action" value="registerSubmit"/>
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