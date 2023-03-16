<?php
  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
  }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Image Management | PHP Motors</title>
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
                <h1>Image Management</h1>
                <p>Welcome to the Image Management page. Please select one of the options below.</p>
                <h2>Add New Vehicle Image</h2>
                <?php
                    if (isset($message)) { 
                        echo $message; 
                    } 
                ?>
                <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                    <fieldset class="fieldset">
                        <legend>All fields required</legend>
                        <h2>Vehicle</h2>
                        <?php echo $prodSelect; ?><br>
                        <h2>Upload Image</h2>
                        <input type="file" name="file1">
                        <input type="submit" class="regbtn" value="Upload">
                        <input type="hidden" name="action" value="upload">
                    </fieldset>
                </form>
                <h2>Existing Images</h2>
                <p class="notice">If deleting an image, delete the thumbnail as well, and vice versa.</p>
                <?php
                    if (isset($imageDisplay)){
                        echo $imageDisplay;
                    }
                ?>
        
            </main>
            <hr>
            <footer>
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
            </footer>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>