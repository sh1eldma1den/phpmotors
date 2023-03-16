<?php
    if ($_SESSION['loggedin'] != TRUE) {
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
    <title>Update Account Information | PHP Motors</title>
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
        <div class="formDiv">
            <?php
              if (isset($message)) {
                    echo $message;
              }
            ?>
            <h1>Account Update</h1>
            
            <form method="post" action="/phpmotors/accounts/index.php">
                <fieldset class="fieldset"> 
                    <legend>All fields required</legend> 
                    <label class="clientFname fieldsetLabel">First name: 
                        <input type="text" name="clientFirstname" id="clientFirstname" pattern="[A-Za-z .-]{2,30}" required
                         <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  elseif(isset($clientInfo['clientFirstname'])) {echo "value='$clientInfo[clientFirstname]'";}?>/>
                    </label>
                    <label class="clientLname fieldsetLabel">Last name:
                        <input type="text" name="clientLastname" id="clientLastname" pattern="[A-Za-z .-]{2,30}" required 
                         <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  elseif(isset($clientInfo['clientLastname'])) {echo "value='$clientInfo[clientLastname]'";}?>
                        />
                    </label>
                    <label class="email fieldsetLabel">Email: 
                            <input type="email" name="clientEmail" id="clientEmail" required
                            <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  elseif(isset($clientInfo['clientEmail'])) {echo "value='$clientInfo[clientEmail]'";}?>/>
                    </label>
                    <input type="submit" class="submitBtn" value="Update Info"/>
                    <input type="hidden" name="action" value="updateInfo"/>
                    <input type="hidden" name="clientId" value="
                        <?php   
                            if(isset($clientInfo['clientId'])){ echo $clientInfo['clientId'];} 
                            elseif(isset($clientId)){ echo $clientId; } 
                        ?>
                    ">
                </fieldset> 
            </form> 
            <h1>Change Your PHP Motors Password</h1>       
            <form method="post" action="/phpmotors/accounts/index.php">
                <fieldset class="fieldset"> 
                    <legend>This will change the existing password.</legend>         
                    <label class="newClientPw fieldsetLabel">Password:<br> 
                      <em>*Passwords must be at least 8 characters and contain at least 1 number,
                         1 capital letter and 1 special character.*</em>
                        <input type="password" name="clientPassword" id="password" 
                        required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/>
                    </label>
                    <input type="submit" class="submitBtn" value="Update Password"/>
                    <input type="hidden" name="action" value="updatePassword"/>
                    <input type="hidden" name="clientId" value="
                        <?php   
                            if(isset($clientInfo['clientId'])){ echo $clientInfo['clientId'];} 
                            elseif(isset($clientId)){ echo $clientId; } 
                        ?>
                    ">
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
<?php unset($_SESSION['message']); ?>