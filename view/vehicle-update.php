<?php
    // Build the classifications option list
    $classifList = '<select name="classificationId" id="classificationId">';
    $classifList .= "<option>Choose a Car Classification</option>";
    foreach ($classifications as $classification) {
        $classifList .= "<option value='$classification[classificationId]'";
            if(isset($classificationId)){
                if($classification['classificationId'] == $classificationId){
                $classifList .= 'selected';
            }
        } elseif(isset($invInfo['classificationId'])){
            if($classification['classificationId'] == $invInfo['classificationId']){
                $classifList .= 'selected';
                }
        }
        $classifList .= ">$classification[classificationName]</option>";
    }
    $classifList .= '</select>';
    if ($_SESSION['loggedin'] !== TRUE AND $_SESSION['clientData']['clientLevel'] == 1) {
        header('Location: /phpmotors/index.php');
    }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php if(isset($invInfo['invYear']) && isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		            echo "Modify $invInfo[invYear] $invInfo[invMake] $invInfo[invModel]";} 
	                elseif(isset($invYear) && isset($invMake) && isset($invModel)) { 
		            echo "Modify $invYear $invMake $invModel"; }?>| PHP Motors</title>
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
                if(isset($invInfo['invYear']) && isset($invInfo['invMake']) && isset($invInfo['invModel'])) { 
	                echo "Modify $invInfo [invYear] $invInfo[invMake] $invInfo[invModel]";
                } 
                elseif(isset ($invYear) && isset($invMake) && isset($invModel)) { 
	                echo "Modify $invYear $invMake $invModel"; 
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
            <label class="dropDown" id="classificationId">Classification:</label>
              <?php echo $classifList; ?>
              <label class="fieldsetLabel">invYear
              <input type="number" name="invYear" id="invYear" required
              <?php if(isset($invYear)){echo "value='$invYear'";}  elseif(isset($invInfo['invYear'])) {echo "value='$invInfo[invYear]'"; }?>>
            <label class="fieldsetLabel">Make:
              <input type="text" name="invMake" id="invMake" required
              <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
            </label>
            <label class="fieldsetLabel">Model:
              <input type="text" name="invModel" id="invModel" required
              <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
            </label>
            <label class="fieldsetLabel">Description:
              <input type="text" name="invDescription" id="invDescription" required
                    <?php if(isset($invDescription)) {echo "value='$invDescription"; } elseif(isset($invInfo['invDescription'])) {echo "value='$invInfo[invDescription]'"; }?>
                >
            </label>
            <label class="fieldsetLabel">Image:
              <input type=text name="invImage" id="invImage" required placeholder="/phpmotors/images/vehicles/no-image.png"
              <?php if(isset($invImage)){echo "value='$invImage'";} elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?>>
            </label>
            <label class="fieldsetLabel">Thumbnail:
              <input type=text name="invThumbnail" id="invThumbnail" required placeholder="/phpmotors/images/vehicles/no-image.png"
              <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?>>
            </label>
            <label class="fieldsetLabel">Price:
              <input type="number" name="invPrice" id="invPrice" required pattern="d+(.d{2})?" 
              <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?>>
            </label>
            <lable class="fieldsetLabel">Miles
              <input type="number" name="invMiles" id="invMiles" required
              <?php if(isset($invMiles)){echo "value='$invMiles'";}  elseif(isset($invInfo['invMiles'])) {echo "value='$invInfo[invMiles]'"; }?>>
            <label class="fieldsetLabel">Stock:
              <input type="number" name="invStock" id="invStock" required
              <?php if(isset($invStock)){echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?>>
            </label>
            <label class="fieldsetLabel">Color:
              <input type="text" name="invColor" id="invColor" required
              <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>>
            </label>
            <input type="submit" class="submitBtn" value="Update Vehicle"/>
            <input type="hidden" name="action" value="updateVehicle"/>
            <input type="hidden" name="invId" value="
                <?php   
                    if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
                    elseif(isset($invId)){ echo $invId; } 
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