<?php

// server-side validation of email address input
function checkEmail($clientEmail)
{
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
}

// Server-side validatioin of password input

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword)
{
  $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
  return preg_match($pattern, $clientPassword);
}

// Build a navigation bar using the $classifications array
function getNav($classifications)
{
  $navList = '<ul>';
  $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
  foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) .
      "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
  }
  $navList .= '</ul>';
  return $navList;
}

// Build the classifications select list
function buildClassificationList($classifications)
{
  $classificationList = '<select name="classificationId" id="classificationList">';
  $classificationList .= "<option>Choose a Classification</option>";
  foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
  }
  $classificationList .= '</select>';
  return $classificationList;
}

// Build a display of vehicles within an unordered list
function buildVehiclesDisplay($vehicles)
{
  $dv = '<ul id="inv-display">';
  foreach ($vehicles as $vehicle) {
    $dv .= '<li>';
    $dv .= "<a href='/phpmotors/vehicles/?action=detail&invId=" . urlencode($vehicle['invId']) .
      "' title='View more information about this $vehicle[invMake] $vehicle[invModel].'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel]'></a>";
    $dv .= '<hr>';
    $dv .= "<h2>$vehicle[invYear] $vehicle[invMake] $vehicle[invModel]<h2>";
    $dv .= "<span>Price: $" . number_format($vehicle['invPrice'], 2, ".", ",") . "</span>";
    $dv .= "<p><a href='/phpmotors/vehicles/?action=detail&invId=" . urlencode($vehicle['invId']) .
      "' title='View more information about this $vehicle[invMake] $vehicle[invModel].'>More</a></p>";
    $dv .= '</li>';
  }
  $dv .= '</ul>';
  return $dv;
}

// Build a display of vehicle details within nested divs
function buildVehicleDetail($invInfo, $imagePrimary, $imageThumbnail)
{
    $invDisplay = "<div id='vehicle-detail'>";
  $invDisplay .= "<div id='picture-div'><img src='$imagePrimary[imgPath]' alt='Image of $invInfo[invYear] $invInfo[invMake] $invInfo[invModel]'></div>";
  $invDisplay .= "<div id='info-div'><h1>$invInfo[invYear] $invInfo[invMake] $invInfo[invModel]</h1>";
  $invDisplay .= "<p>Color: $invInfo[invColor]<br> Miles: $invInfo[invMiles] <br>Classification: $invInfo[classificationId]<br>";
  $invDisplay .= "Vehicle Description: $invInfo[invDescription]</p><br>";
  $invDisplay .= "<h2>Price: $" . number_format($invInfo['invPrice'], 2, ".", ",") . "</h2></div>";
  $invDisplay .= "<div id='thumb-div'>";
  foreach ($imageThumbnail as $thumbnail) {
    $invDisplay .= "<img src='$thumbnail[imgPath]' alt='Image of $invInfo[invYear] $invInfo[invMake] $invInfo[invModel]'>";
  }
  $invDisplay .= '</div>';
  $invDisplay .= '</div>';
  return $invDisplay;
}

function pagination($totalPages, $page, $searchStr)
{
  $beyond = $totalPages +1;
  $next = $page + 1;
  $prev = $page - 1;

  $pagLink = "<ul class='paginationBar'>";
  // Build "Previous" link
  if ($page !== 1) {
    $pagLink .= "<li><a class='page-link' href='/phpmotors/search?action=searchSubmit&searchStr=$searchStr&page=" . $prev . "'title='Go to page " . $prev . " of results'> < < < </a></li>";
  }
  // Build Links for page numbers
  for ($i = 1; $i <= $totalPages; $i++) {
    $pagLink .= "<li class='page-item'><a class='page-link";
    if ($i === $page) {
      $pagLink .= " currentPage";
    }
    $pagLink .= "' href='/phpmotors/search?action=searchSubmit&searchStr=$searchStr&page=" . $i . "' title='Go to page " . $i . " of results'>" . $i . "</a></li>";
  }
  // Build "Next" link
  if ($next !== $beyond) {
    ++$page;
    $pagLink .= "<li><a class='page-link' href='/phpmotors/search?action=searchSubmit&searchStr=$searchStr&page=" . $next . "' title='Go to page " . $next . " of results'> > > > </a></li>";
  }
  $pagLink .= "</ul>";
  return $pagLink;
}

// build a search result based on paginated search criteria
function buildSearchDisplay($resNum, $searchRes, $paginationBar)
{
  $searchDisplay = "<h3 id='search-number'>" . $resNum . " Results found.</h3>";
  $searchDisplay .= "<ul id='search-result'>";
  foreach ($searchRes as $result) {
    $searchDisplay .= '<li>';
    $searchDisplay .= "<div id='result-img'><img src='$result[imgPath]' alt='Image of $result[invYear] $result[invMake] $result[invModel]'></div>";
    $searchDisplay .= "<div id='result-info'><h1>$result[invYear] $result[invMake] $result[invModel]</h1>";
    $searchDisplay .= "<p>Color: $result[invColor]  |  Classification: $result[classificationName]<br>";
    $searchDisplay .= "<span>Price: $" . number_format($result['invPrice'], 2, ".", ",") . "</span>";
    $searchDisplay .= "<p><a href='/phpmotors/vehicles/?action=detail&invId=" . urlencode($result['invId']) . "' title='View more information about this $result[invMake] $result[invModel].'>More</a></p></div>";
    $searchDisplay .= '</li>';
  }
  $searchDisplay .= "</ul>";
  if ($paginationBar != NULL) {
    $searchDisplay .= "<span id='paginationBar'>" . $paginationBar . "</span";
  }
  return $searchDisplay;
}

/* * ********************************************************
* * Functions for working with images
* * ****************************************************** * */

// Adds "-tn" designation to file name
function makeThumbName($image)
{
  $i = strrpos($image, '.');
  $image_name = substr($image, 0, $i);
  $ext = substr($image, $i);
  $image = $image_name . '-tn' . $ext;
  return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray)
{
  $id = '<ul id="image-display">';
  foreach ($imageArray as $image) {
    $id .= '<li>';
    $id .= "<img src='$image[imgPath]' title='$image[invYear] $image[invMake] $image[invModel] image on PHP Motors.com' 
                alt='$image[invYear] $image[invMake] $image[invModel] image on PHP Motors.com'>";
    $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]'
                title='Delete the image'>Delete $image[imgName]</a></p>";
    $id .= '</li>';
  }
  $id .= '</ul>';
  return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles)
{
  $prodList = '<select name="invId" id="invId">';
  $prodList .= "<option>Choose a Vehicle</option>";
  foreach ($vehicles as $vehicle) {
    $prodList .= "<option value='$vehicle[invId]'>$vehicle [invYear] $vehicle[invMake] $vehicle[invModel]</option>";
  }
  $prodList .= '</select>';
  return $prodList;
}

// Handles the file upload process and returns the path
// Stores the file path into the database
function uploadFile($name)
{
  // Gets the paths, full and local directory
  global $image_dir, $image_dir_path;
  if (isset($_FILES[$name])) {
    // Gets the actual file name
    $filename = $_FILES[$name]['name'];
    if (empty($filename)) {
      return;
    }
    // Fet the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for db storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
  }
}

// Processes images by getting paths and
// creating smaller versions of the image
function processImage($dir, $filename)
{
  // Set up the variables
  $dir = $dir . '/';
  // Set up the image path
  $image_path = $dir . $filename;
  // Set up the thumbnail image path
  $image_path_tn = $dir . makeThumbName($filename);
  // Create a thumbnail image that's a max of 200 px square
  resizeImage($image_path, $image_path_tn, 200, 200);
  // Resize the original to a max of 500 px square
  resizeImage($image_path, $image_path, 500, 500);
}

// Checks and resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{
  // Get image type
  $image_info = getimagesize($old_image_path);
  $image_type = $image_info[2];
  // Set up the function names
  switch ($image_type) {
    case IMAGETYPE_JPEG:
      $image_from_file = 'imagecreatefromjpeg';
      $image_to_file = 'imagejpeg';
      break;
    case IMAGETYPE_GIF:
      $image_from_file = 'imagecreatefromgif';
      $image_to_file = 'imagegif';
      break;
    case IMAGETYPE_PNG:
      $image_from_file = 'imagecreatefrompng';
      $image_to_file = 'imagepng';
      break;
    default:
      return;
  } // end of switch statement
  // Get the old image and its height and width
  $old_image = $image_from_file($old_image_path);
  $old_width = imagesx($old_image);
  $old_height = imagesy($old_image);
  // Calculate height and width ratios
  $width_ratio = $old_width / $max_width;
  $height_ratio = $old_height / $max_height;
  // If image is larger than specified ratio, create a new image
  if ($width_ratio > 1 || $height_ratio > 1) {
    // Calculate height and width for the new image
    $ratio = max($width_ratio, $height_ratio);
    $new_height = round($old_height / $ratio);
    $new_width = round($old_width / $ratio);
    // Create new image
    $new_image = imagecreatetruecolor($new_width, $new_height);
    // Set the transparency accordin to image type
    if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
    }
    if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
    }
    // Copy old image to new image - resizes image
    $new_x = 0;
    $new_y = 0;
    $old_x = 0;
    $old_y = 0;
    imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
    // Write the new image to a new file
    $image_to_file($new_image, $new_image_path);
    // Free memory associated with the new image
    imagedestroy($new_image);
  } else {
    // Write the old image to a new file
    $image_to_file($old_image, $new_image_path);
  }
  // Free memory associated with old image
  imagedestroy($old_image);
}


