<?php

// * * * * Model for vehicle inventory image uploads

// Add image information to the db table
function storeImages($imgPath, $invId, $imgName){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // SQL statement
    $sql = 'INSERT INTO images (invId, imgPath, imgName)
            VALUES (:invId, :imgPath, :imgName)';
    // Prepare statement
    $stmt = $db->prepare($sql);
    // Store the full size image information as real values
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    // execute
    $stmt->execute();

    // Make and store the thumbnail image information
    // Change name in path
    $imgPath = makeThumbName($imgPath);
    // Change name in file name
    $imgName = makeThumbName($imgName);
    // Store the thumbnail information 
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    //Execute
    $stmt->execute();
    // Check for success of insert
    $rowsChanged = $stmt->rowCount();
    // Close db connection
    $stmt->closeCursor();
    // Return success/failure
    return $rowsChanged;
}

// Get image information from images table
function getImages(){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // SQL statement
    $sql = 'SELECT images.imgId, images.imgName, images.imgPath, images.imgDate, inventory.invId, inventory.invYear, inventory.invMake, inventory.invModel
            FROM images
            JOIN inventory
            ON images.invId = inventory.invId';
    // prepare SQL statement
    $stmt = $db->prepare($sql);
    // Execute
    $stmt->execute();
    // Generate associative array
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close db connection
    $stmt->closeCursor();
    // return the array
    return $imageArray;
}

// Delete image information from the images table
function deleteImage($imgId){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // SQL statement
    $sql = 'DELETE FROM images WHERE imgID = :imgId';
    // prepare sql statement
    $stmt = $db->prepare($sql);
    // Tell the db what kind of data this it
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    // Execute
    $stmt->execute();
    // Generate success/failure indicator
    $result = $stmt->rowCount();
    // Close db interaction
    $stmt->closeCursor();
    // return success/
    return $result;
}

// Check for an existing image
function checkExistImage($imgName){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = 'SELECT imgName FROM images WHERE imgName = :name';
    // prepare the SQL statement
    $stmt = $db->prepare($sql);
    // Store the type of data for the db
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Return matching rows
    $imageMatch = $stmt->fetch();
    // Close db connection
    $stmt->closeCursor();
    // return matching rows
    return $imageMatch;
}

// Gets thumbnal image paths information from the 
// images table based on invId
function getThumbnail($invId){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = 'SELECT imgPath FROM images WHERE invId = :invId AND imgPath LIKE "%tn%"';
    // prepare the SQL statement
    $stmt = $db->prepare($sql);
    // Store the type of data for the db
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Return matching rows
    $imageThumbnail = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close db connection
    $stmt->closeCursor();
    // return matching rows
    return $imageThumbnail;
}

// Gets primary image paths information from the 
// images table based on invId
function getPrimary($invId){
    // Create a connection object using the phpmotorsConnect function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = 'SELECT imgPath 
            FROM images 
            WHERE invId = :invId 
            AND imgPath NOT LIKE "%tn%"';
    // prepare the SQL statement
    $stmt = $db->prepare($sql);
    // Store the type of data for the db
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    // Execute statement
    $stmt->execute();
    // Return matching rows
    $imagePrimary = $stmt->fetch();
    // Close db connection
    $stmt->closeCursor();
    // return matching rows
    return $imagePrimary;
}
