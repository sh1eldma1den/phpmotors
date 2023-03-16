<?php

// Images Controller

session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the vehicles model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
// Get the uploads model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';

// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = getNav($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

/* * ***************************************************************
* Variables for use with the Image Upload Functionality
* *************************************************************** * */
// directory name where uploaded images are stored
$image_dir = '/phpmotors/images/vehicles';
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

switch ($action) {
    case 'upload':
        // Store the incoming vehicle id and primary picture indicator
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // Store the name of the uploaded image
        $imgName = $_FILES['file1']['name'];
        // Check to see if it already exists in db
        $imageCheck = checkExistImage($imgName);
        if ($imageCheck) {
            $message = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
            $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
        } else {
            // Upload the image, store the returned path to the file
            $imgPath = uploadFile('file1');
            // Insert the image information to the database, get the result
            $result = storeImages($imgPath, $invId, $imgName);
            // Set a message for result of insert
            if ($result){
                $message = '<p class="notice">The upload was successful.</p>';
            } else {
                $message = 'p class="notice">Sorry, the upload failed.</p>';
            }
        }
        // Store message to session
        $_SESSION['message'] = $message;
        // Redirect to this controller for default action
        header('location: .');
    break;
    case 'delete':
        // Get the image name and id
        $filename = trim(filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $imgId = trim(filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT));
        // Build the full path to the image to be deleted
        $target = $image_dir_path . '/' . $filename;
        // Check if the file exists at the location
        if (file_exists($target)){
            $result = unlink($target);
        }
        // Remove from db only if physical file deleted
        if($result){
            $remove = deleteImage($imgId);
        }
        // Set a message based on the delete result
        if ($remove) {
            $message = "<p class='notice'>$filename was successfully deleted.</p>";
        } else {
            $message =  "<p class='notice'>$filename was NOT deleted.</p>";
        }
        // Store message to session
        $_SESSION['message'] = $message;
        // Redirect to this controller for default action
        header('location: .');
    break;
    default:
        // Call function to return image info from db
        $imageArray = getImages();
        // Build the image information into HTML for display
        if(count($imageArray)){
            $imageDisplay = buildImageDisplay($imageArray);
        } else {
            $imageDisplay = '<p class="notice">No images could be found.</p>';
        }
        // Get vehicles information from db
        $vehicles = getVehicles();
        // Build a select list of vehicle information for the view
        $prodSelect = buildVehiclesSelect($vehicles);
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/image-admin.php';
        exit;
    break;
}