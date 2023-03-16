<?php
    if ($_SESSION['loggedin']  < 2) {
        header('Location: /phpmotors/index.php');
    }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		            echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	                elseif(isset($invMake) && isset($invModel)) { 
		            echo "Delete $invMake $invModel"; }?>| PHP Motors</title>
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
        <h1><?php 
                if(isset($invInfo['invMake']) && isset($invInfo['invModel'])) { 
	                echo "Delete $invInfo[invMake] $invInfo[invModel]";
                } 
                elseif(isset($invMake) && isset($invModel)) { 
	                echo "Delete $invMake $invModel"; 
                }
            ?>
        </h1>
        <?php
            if (isset($_SESSION['message'])) { 
              echo $message; 
            } 
        ?>
        <form method="post" action="/phpmotors/vehicles/index.php">
          <fieldset class="fieldset">  
            <legend>All fields required</legend>
            <label for="invYear" class="fieldsetLabel">Year:</label>
              <input type="number" name="invYear" id="invYear" readonly
              <?php if(isset($invInfo['invYear'])) {echo "value='$invInfo[invYear]'"; }?>>
            <label for="invMake" class="fieldsetLabel">Make:</label>
              <input type="text" name="invMake" id="invMake" readonly
              <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
            <label for="invModel" class="fieldsetLabel">Model:</label>
              <input type="text" name="invModel" id="invModel" readonly
              <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
            <label for="invDescription" class="fieldsetLabel" id="invDescription">Description:</label>
              <textarea name="invDescription" readonly id="invDescription">
                    <?php if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?>>
              </textarea>
            <p>Confirm Vehicle Deletion. The delete is permanent.</p>
            <input type="submit" class="submitBtn" value="Delete Vehicle"/>
            <input type="hidden" name="action" value="deleteVehicle"/>
            <input type="hidden" name="invId" value="
                <?php   
                    if(isset($invInfo['invId'])){ echo $invInfo['invId'];}  
                ?>
            ">
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