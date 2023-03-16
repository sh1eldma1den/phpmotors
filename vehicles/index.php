<?php

/*
* Vehicles Controller
*/

// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the vehicles model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
// Get the uploads model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';



// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = getNav($classifications);

// View control statements
$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
  }

switch ($action) {
  // view if navigating to add-classification.php 
  case 'add-classification':
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
  break;
  // what happens upon submitting a new vehicle classification while in add-classification.php
  case 'classSubmit':
    // Filter and store the data
    $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_SPECIAL_CHARS));
    if(empty($classificationName)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
      exit; 
    }
    // Send the data to the model
    $regOutcome = addClass($classificationName);
    // Check and report the result
    if($regOutcome === 1){
    //    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
    //    $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classificationName['classificationName']).
    //        "' title='View our $classificationName[classificationName] product line'>$classificationName[classificationName]</a></li>";
    //    exit;
        header('Location: /phpmotors/vehicles');
    }   else {
        $message = "<p>Sorry, but the upload failed. Please try again.</p>";
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
        exit;
    }
  break;
  // view if navigating to add-vehicle.php
  case 'add-vehicle':
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
  // what happens upon submitting a new vehicle while in add-vehicle.php
  break;
  case 'vehicleSubmit':
    // Filter and store the data
    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invYear = trim(filter_input(INPUT_POST, 'invYear', FILTER_SANITIZE_NUMBER_INT));
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ALLOW_FRACTION));
    $invMiles = trim(filter_input(INPUT_POST, 'invMiles', FILTER_SANITIZE_NUMBER_INT));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
   
    // Check for missing data
    if(empty($classificationId) || empty($invYear) || empty($invMake) ||  empty($invModel) || empty($invDescription) || empty($invImage)  
          || empty($invThumbnail) || empty($invPrice) || empty($invMiles) || empty($invStock) || empty($invColor)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
      exit; 
    }
    // Send the data to the model
    $addOutcome = addVehicle($classificationId,
                            $invYear,
                            $invMake,
                            $invModel,
                            $invDescription,
                            $invImage,
                            $invThumbnail,
                            $invPrice,
                            $invMiles,
                            $invStock,
                            $invColor);
    // Check and report the result
    if($addOutcome === 1){
        $message = "<p>Your upload of $invYear $invMake $invModel was successful.</p>";
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        exit;
    } else {
        $message = "<p>Sorry, but the upload failed. Please try again.</p>";
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        exit;
    }
  break;
  // get vehicles by classificationId for use in update and delete processes
  case 'getInventoryItems':
    // get the classificationId
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    //Fetch the vehicles by classificationId from the db
    $inventoryArray = getInventoryByClassification($classificationId);
    // convert the array to a JSON object and send it back
    echo json_encode($inventoryArray);
  break;
  case 'mod':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
      $message = 'Sorry, no vehicle information could be found.';
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
    exit;
  break;
  // update existing vehicles - submitting update
  case 'updateVehicle':
    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invYear = trim(filter_input(INPUT_POST, 'invYear', FILTER_SANITIZE_NUMBER_INT));
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    $invMiles = trim(filter_input(INPUT_POST, 'invMiles', FILTER_SANITIZE_NUMBER_INT));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if (empty($classificationId) || empty($invYear) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) 
      || empty($invThumbnail) || empty($invPrice) || empty($invMiles) || empty($invStock) || empty($invColor)) {
      $message = '<p>Please complete all information for the updated item! Double check the classification of the item.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
      exit;
    }
    $updateResult = updateVehicle($classificationId, 
                                  $invYear,
                                  $invMake, 
                                  $invModel, 
                                  $invDescription, 
                                  $invImage, 
                                  $invThumbnail, 
                                  $invPrice,
                                  $invMiles, 
                                  $invStock, 
                                  $invColor, 
                                  $invId);
    if ($updateResult) {
      $message = "<p class='notice'>Congratulations, the $invYear $invMake $invModel was successfully updated.</p>";
      header('location: /phpmotors/vehicles/');
      $_SESSION['message'] = $message;
    } else {
      $message = "<p>Error. The vehicle was not updated.</p>";
      $_SESSION['message'] = $message;
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
      exit;
    }
  break;
  case 'del':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
      $message = 'Sorry, no vehicle information could be found.';
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-delete.php';
    exit;
  break;
  // delete existing vehicles - submitting delete
  case 'deleteVehicle':
    $invYear = trim(filter_input(INPUT_POST, 'invYear', FILTER_SANITIZE_NUMBER_INT));
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    $deleteResult = deleteVehicle($invId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations, the $invYear $invMake $invModel was successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
    } else {
      $message = "<p>Error. The vehicle was not deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    }
  break;
  case 'classification':
    $classificationName = trim(filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $vehicles = getVehiclesByClassification($classificationName);
    if(!count($vehicles)){
      $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
      $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }
    // echo $vehicleDisplay;
    // exit;
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/classification.php';
  break;
  // Deliver detail view of specific vehicle
  case 'detail':
    $invId = trim(filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invInfo = getInvItemInfo($invId);
    if(!count($invInfo)){
      $message = "<p class='notice'>Sorry, no information on the $invInfo[invYear] $invInfo[invMake] $invInfo[invModel] could be found.</p>";
    } else {
      $imagePrimary = getPrimary($invId);
      $imageThumbnail = getThumbnail($invId);
      $invDisplay = buildVehicleDetail($invInfo, $imagePrimary, $imageThumbnail);
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-detail.php';
    }
  break;
  // default view
  default:
    $classificationList = buildClassificationList($classifications);
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-management.php';
    exit;
  break;
}