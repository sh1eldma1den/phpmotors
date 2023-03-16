<?php

/*
* Accounts Controller
*/

// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the accounts model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/accounts-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';



// Get the array of classifications
$classifications = getClassifications();
//var_dump($classifications);
//	exit;

// Build a navigation bar using the $classifications array
$navList = getNav($classifications);
//  $navList = '<ul>';
//  $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
//  foreach ($classifications as $classification) {
//   $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
//  }
//  $navList .= '</ul>';
// echo $navList;
//exit;


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
  }

switch ($action) {
  case 'login':
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
  break;
  case 'register':
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
  break;
  case 'registerSubmit':
    // Filter and store the data
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    // Validate email
    $clientEmail = checkEmail($clientEmail);
    // Validate password
    $checkPassword = checkPassword($clientPassword);
    // Check for existing email
    $existingEmail = checkExistEmail($clientEmail);
    // Handle existing email during registration
    if ($existingEmail){
      $message = '<p>An account with that email address already exists. Do you want to log in instead?</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      exit;
    }
    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
      exit; 
    }
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    // Check and report the result
    if($regOutcome === 1){
      setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
      $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
      header('Location: /phpmotors/accounts/?action=login');
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
      exit;
    }
  break;
  case 'loginSubmit':
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientEmail = checkEmail($clientEmail);
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $checkPassword = checkPassword($clientPassword);
    // Run basic checks, return if errors
    if (empty($clientEmail) || empty($checkPassword)) {
      // echo 1;
      // exit;
      $message = '<p class="notice">Please provide a valid email address and password.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      exit;
    }
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if (!$hashCheck) {
      //echo 2;
      //exit;
      $message = '<p class="notice">Please check your password and try again.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
      exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
    exit;
  break; 
  case 'logout':
    // Unset stored client data in session
    unset ($_SESSION['clientData']);
    // Destroy current session
    session_destroy();
    // Redirect to home view
    header('Location: /phpmotors/index.php');
    exit;
  break; 
  case 'updateAccount':
    $clientInfo = getClientInfo($_SESSION['clientData']['clientId']); 
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php'; 
  break;
  case 'updateInfo':
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    // Check for existing email
    if ($clientEmail != $_SESSION['clientData']['clientEmail']){
      // Validate email
      $clientEmail = checkEmail($clientEmail);
      $existingEmail = checkExistEmail($clientEmail);
      // Check for existing email address in the table
      if ($existingEmail) {
        $_SESSION['message'] = '<p class="notice">That email address already exists. Please chose another.</p>';
        include $_SERVER['DOCUMENT_ROOT'] . '/view/client-update.php';
        exit;
      }
    }
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)) {
      $message = '<p>Please complete all fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
    $updateResult = updateInfo($clientFirstname, $clientLastname, $clientEmail, $clientId);
    if ($updateResult) {
      $clientInfo = getClientInfo($clientId);
      $_SESSION['loggedin'] = TRUE;
      array_pop($clientInfo);
      $_SESSION['clientInfo'] = $clientInfo;
      $_SESSION['message'] = "<p class='notice'>Congratulations, information was successfully updated.</p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    } else {
      $message = "<p>Sorry, an error occured. Your information was not updated.</p>";
      $_SESSION['message'] = $message;
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
  break;
  case 'updatePassword':
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    $checkPassword = checkPassword($clientPassword);
    if ($checkPassword == 0){
      $message = '<p class="notice">Please check your password and try again.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
    if (empty($clientPassword) ||  empty($clientId)) {
      $message = '<p>Please complete all fields.</p>';
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    $updateResult = updatePassword($hashedPassword, $clientId);
    if ($updateResult) {
      $message = "<p class='notice'>Congratulations, your password was successfully updated.</p>";
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      $_SESSION['message'] = $message;
    } else {
      $message = "<p>Sorry, an error occured. Your password was not updated.</p>";
      $_SESSION['message'] = $message;
      include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
      exit;
    }
  break;
  default: 
  include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
  break;
}

