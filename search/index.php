<?php

/*
* * * * * * Search Controller * * * * * * *
*/

// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Access the helper functions
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
// Get the vehicles model 
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
// Get the search model 
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/search-model.php';
// Get the uploads model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';


// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = getNav($classifications);

// View control statements
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
  // when the search icon is clicked
  case 'searchSubmit':
    $searchStr = trim(filter_input(INPUT_POST, 'searchStr', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if ($searchStr == NULL) {
        $searchStr = trim(filter_input(INPUT_GET, 'searchStr', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }
    // check for missing data
    if (empty($searchStr)) {
        $message = '<p>No information found. Try your search again.</p>';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-result.php';
        exit;
    } 
      // Look for this as part of the link and if it doesn't exist, default it to page 1
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
    if (empty($page)) {
        $page = 1;
    }
    // Send data to the model
    $searchRes = getSearch($searchStr);
    // Check and report the result
    $resNum = count($searchRes);
    if ($resNum < 1) {
        $message = "<p class='notice'>Sorry, no results matching '$searchStr' could be found. Please check spelling and try again.</p>";
    } elseif ($resNum > 10) {
        // Determine how many pages needed based on 10 results per page
        $pageLimit = 10;
        $totalPages = ceil($resNum / $pageLimit);
        $limit1 = ($page - 1) * $pageLimit;
        $limit2 = $pageLimit;

        // Rerun the query based on page number
        $searchRes2 = getSearch2($searchStr, $limit1, $limit2); 
        // Create the pagination based on total pages, page number and search string
        $paginationBar = pagination($totalPages, $page, $searchStr);
        // Build the results page based on the $searchRes2 above
        $searchDisplay = buildSearchDisplay($resNum, $searchRes2, $paginationBar);
    } else {
        // Since there is only one page, build the display based on the original query.
        $searchDisplay = buildSearchDisplay($resNum, $searchRes, NULL); 
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-result.php';
    exit;
    break;
  // default case statement
  default:
    include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search.php';
    break;
}
