<?php

/*
* Accounts Model
*/

// Check for existing email addresses
function checkExistEmail($clientEmail){
     // Create a connection using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SWL statement
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :clientEmail';
    // Create the prepared statement using phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace the placeholders in SQL with the actual variables
    // and tell the db what type of data it is
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Insert data
    $stmt->execute();
    // Fetch any email that matches
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    // Close db interaction
    $stmt->closeCursor();
    // Check to see number of rows returned
    if (empty($matchEmail)){
        return 0;
        // echo 'No match found.';
        // exit;
    } else {
        return 1;
        // echo 'Match found.';
        // exit;
    }
}

// Handling site registrations*/
function regClient(
    $clientFirstname,
    $clientLastname,
    $clientEmail,
    $clientPassword){
       //Create a connection object using the phpmotors connection function:
       $db = phpmotorsConnect();
       // The SQL statement
       $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
                VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)'; 
        // Create the prepared statement using the phpmotors connection
        $stmt = $db->prepare($sql);
        // Replace the placeholders in SQL with the actual variables, 
        // and tells the db what type of data it is
        $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
        $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
        // Insert data
        $stmt->execute();
        // Ask how many rows changed as a result of the insert
        $rowsChanged = $stmt->rowCount();
        // Close db interaction
        $stmt->closeCursor();
        // Return the rows changed (success of insert)
        return $rowsChanged;
}

// Get client data based on an email address
function getClient($clientEmail){
    //Create a connection object using the phpmotors connection function:
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace the placeholders in SQL with the actual variables, 
        // and tells the db what type of data it is
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        // Insert data
    $stmt->execute();
    // Fetch any client that matches
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close db interaction
    $stmt->closeCursor();
    // Return the clientData (success of insert)
    return $clientData;
}

// Updates a client's information in the client table //
function updateInfo($clientFirstname, $clientLastname, $clientEmail, $clientId) {
        //Create a connection object using the phpmotors connection function:
       $db = phpmotorsConnect();
       // The SQL statement
       $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, 
            clientEmail = :clientEmail
            WHERE clientId = :clientId';
        // Create the prepared statement using the phpmotors connection
        $stmt = $db->prepare($sql);
        // Replace the placeholders in SQL with the actual variables, 
        // and tells the db what type of data it is
        $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
        $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        // Insert data
        $stmt->execute();
        // Ask how many rows changed as a result of the insert
        $rowsChanged = $stmt->rowCount();
        // Close db interaction
        $stmt->closeCursor();
        // Return the rows changed (success of insert)
        return $rowsChanged;
}

// Get client information by clientId
function getClientInfo($clientId){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = 'SELECT * FROM clients WHERE clientId = :clientId';
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace placeholders in SQL with actual variables, treats the invId as an interger
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    // requesting an associative array
    $clientInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    //end db interaction
    $stmt->closeCursor();
    //return array
    return $clientInfo;
}
// Updates a client's information in the client table //
function updatePassword($clientPassword, $clientId) {
    //Create a connection object using the phpmotors connection function:
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'UPDATE clients SET clientPassword = :clientPassword
        WHERE clientId = :clientId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace the placeholders in SQL with the actual variables, 
    // and tells the db what type of data it is
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    // Insert data
    $stmt->execute();
    // Ask how many rows changed as a result of the insert
    $rowsChanged = $stmt->rowCount();
    // Close db interaction
    $stmt->closeCursor();
    // Return the rows changed (success of insert)
    return $rowsChanged;
}

