<?php

/*
* Main PHP Motors Model
*/

function getClassifications(){
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect(); 
    // The SQL statement to be used with the database 
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC'; 
    // Create the prepared statement using the phpmotors connection      
    $stmt = $db->prepare($sql);
    // Run the prepared statement 
    $stmt->execute(); 
    // Get the data from the database and 
    // store it as an array in the $classifications variable 
    $classifications = $stmt->fetchAll(); 
    // Close the interaction with the database 
    $stmt->closeCursor(); 
    // Send the array of data back to where the function 
    // was called (this should be the controller) 
    return $classifications;
   }
