<?php
  $classificationList = '<select name="classificationId" id="classificationId">';
  $classificationList .= "<option>Choose a Car Classification</option>";
  foreach ($classifications as $classification){
    $classificationList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)){
      if($classification['classificationId'] == $classificationId){
        echo $classification['classificationId']."<br>";
        $classificationList .= 'selected';
      }
    }
    $classificationList .= ">$classification[classificationName]</option>";
  }
  $classificationList .= '</select>';
  if ($_SESSION['loggedin'] !== TRUE AND $_SESSION['clientData']['clientLevel'] == 1) {
    header('Location: /phpmotors/index.php');
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Add a new vehicle | PHP Motors</title>
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
        <h1>Add a new vehicle to inventory</h1>
        <?php
              if (isset($message)) {
                echo $message;
              }
        ?>
        <form method="post" action="/phpmotors/vehicles/index.php">
          <fieldset class="fieldset">  
            <legend>All fields required</legend>
            <label class="dropDown" id="classificationId">Classification:
              <?php echo $classificationList; ?>
            </label>
            <label class="fieldsetLabel">invYear
              <input type="number" name="invYear" id="invYear" required
              <?php if(isset($invYear)){echo "value='$invYear'";}  ?>>
            <label class="fieldsetLabel">Make:
              <input type="text" name="invMake" id="invMake" required
              <?php if(isset($invMake)){echo "value='$invMake'";}  ?>>
            </label>
            <label class="fieldsetLabel">Model:
              <input type="text" name="invModel" id="invModel" required
              <?php if(isset($invModel)){echo "value='$invModel'";}  ?>>
            </label>
            <label class="fieldsetLabel" id="invDescription">Description:
              <input type="text" name="invDescription" id="invDescription" required
              <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?>>
            </label>
            <label class="fieldsetLabel">Image:
              <input type=text value="/phpmotors/images/vehicles/no-image.png" name="invImage" id="invImage" required
              <?php if(isset($invImage)){echo "value='$invImage'";}  ?>>
            </label>
            <label class="fieldsetLabel">Thumbnail:
              <input type=text value="/phpmotors/images/vehicles/no-image.png" name="invThumbnail" id="invThumbnail" required
              <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>>
            </label>
            <label class="fieldsetLabel">Price:
              <input type="number" name="invPrice" id="invPrice" required pattern="d+(.d{2})?" 
              <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>>
            </label>
            <lable class="fieldsetLabel">Miles
              <input type="number" name="invMiles" id="invMiles" required
              <?php if(isset($invMiles)){echo "value='$invMiles'";}  ?>>
             <label class="fieldsetLabel">Stock:
              <input type="number" name="invStock" id="invStock" required
              <?php if(isset($invStock)){echo "value='$invStock'";}  ?>>
            </label>
            <label class="fieldsetLabel">Color:
              <input type="text" name="invColor" id="invColor" required
              <?php if(isset($invColor)){echo "value='$invColor'";}  ?>>
            </label>
            <input type="submit" class="submitBtn" value="Add"/>
            <input type="hidden" name="action" value="vehicleSubmit"/>
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