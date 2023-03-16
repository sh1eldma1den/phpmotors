<?php

/*
* Vehicles Model
*/

// Inserts a new classification into the carclassification table //
function addClass($classificationName) {
    //Create a connection object using the phpmotors connection function:
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO carclassification (classificationName)
             VALUES (:classificationName)'; 
     // Create the prepared statement using the phpmotors connection
     $stmt = $db->prepare($sql);
     // Replace the placeholders in SQL with the actual variables, 
     // and tells the db what type of data it is
     $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
     // Insert data
     $stmt->execute();
     // Ask how many rows changed as a result of the insert
     $rowsChanged = $stmt->rowCount();
     // Close db interaction
     $stmt->closeCursor();
     // Return the rows changed (success of insert)
     return $rowsChanged;
}

// Inserts a new vehicle into the inventory table //
function addVehicle(
    $classificationId,
    $invYear,
    $invMake,
    $invModel,
    $invDescription,
    $invImage,
    $invThumbnail,
    $invPrice,
    $invMiles,
    $invStock,
    $invColor) {
        //Create a connection object using the phpmotors connection function:
       $db = phpmotorsConnect();
       // The SQL statement
       $sql = 'INSERT INTO inventory (classificationId, invYear, invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invMiles, invStock, invColor)
                VALUES (:classificationId, :invYear, :invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invMiles, :invStock, :invColor)'; 
        // Create the prepared statement using the phpmotors connection
        $stmt = $db->prepare($sql);
        // Replace the placeholders in SQL with the actual variables, 
        // and tells the db what type of data it is
        $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
        $stmt->bindValue(':invYear', $invYear, PDO::PARAM_INT);
        $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
        $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
        $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
        $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
        $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
        $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
        $stmt->bindValue(':invMiles', $invMiles, PDO::PARAM_INT);
        $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
        $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
        // Insert data
        $stmt->execute();
        // Ask how many rows changed as a result of the insert
        $rowsChanged = $stmt->rowCount();
        // Close db interaction
        $stmt->closeCursor();
        // Return the rows changed (success of insert)
        return $rowsChanged;
}

    
// Get vehicles by classificationId
function getInventoryByClassification($classificationId){
    // create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    // create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace placeholders in SQL with the actual variables
    // and tell the db what type of data it is
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    // execute
    $stmt->execute();
    // fetch all matching rows
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // close db interaction
    $stmt->closeCursor();
    // return matching rows
    return $inventory;
}

// Get vehicle information by invId
function getInvItemInfo($invId){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace placeholders in SQL with actual variables, treats the invId as an interger
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    // requesting an associative array
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    //end db interaction
    $stmt->closeCursor();
    //return array
    return $invInfo;
}

// Updates a vehicle in the inventory table //
function updateVehicle(
    $classificationId,
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
    $invId) {
        //Create a connection object using the phpmotors connection function:
       $db = phpmotorsConnect();
       // The SQL statement
       $sql = 'UPDATE inventory SET classificationId = :classificationId, invYear = :invYear,
            invMake = :invMake, invModel = :invModel, invDescription = :invDescription, 
            invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice,
            invMiles = :invMiles, invStock = :invStock, invColor = :invColor
            WHERE invId = :invId';
        // Create the prepared statement using the phpmotors connection
        $stmt = $db->prepare($sql);
        // Replace the placeholders in SQL with the actual variables, 
        // and tells the db what type of data it is
        $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
        $stmt->bindValue(':invYear', $invYear, PDO::PARAM_INT);
        $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
        $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
        $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
        $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
        $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
        $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
        $stmt->bindValue(':invMiles', $invMiles, PDO::PARAM_INT);
        $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
        $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
        // Insert data
        $stmt->execute();
        // Ask how many rows changed as a result of the insert
        $rowsChanged = $stmt->rowCount();
        // Close db interaction
        $stmt->closeCursor();
        // Return the rows changed (success of insert)
        return $rowsChanged;
}

// Deletes a vehicle in the inventory table //
function deleteVehicle($invId) {
     //Create a connection object using the phpmotors connection function:
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace the placeholders in SQL with the actual variables, 
    // and tells the db what type of data it is
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    // Insert data
    $stmt->execute();
    // Ask how many rows changed as a result of the insert
    $rowsChanged = $stmt->rowCount();
    // Close db interaction
    $stmt->closeCursor();
    // Return the rows changed (success of delete)
    return $rowsChanged;
}

// Gets a list of vehicles based on the classification
function getVehiclesByClassification($classificationName){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT inventory.invId, inventory.invYear, inventory.invMake, inventory.invModel, inventory.invPrice, img.imgPath
            FROM inventory 
            INNER JOIN images img ON img.invId = inventory.invId
            WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)
            AND img.imgPath LIKE "%tn.___"';
    // Create the prepared statememnt using phpmotors connection
    $stmt = $db->prepare($sql);
    // Replace placeholders with actual variables and tell the db what type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Execute
    $stmt->execute();
    // Fetch all matching rows
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close db connection
    $stmt->closeCursor();
    // Return matching rows
    return $vehicles;
}   

// Get information for all vehicles
function getVehicles (){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // SQL statement
    $sql = 'SELECT * FROM inventory';
    // Create the prepared statement
    $stmt = $db->prepare($sql);
    // Execute statement
    $stmt->execute();
    // Fetch all matching rows
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close db connection
    $stmt->closeCursor();
    // Return matching rows
    return $invInfo;
}
