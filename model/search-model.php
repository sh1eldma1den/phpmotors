<?php

// * * * * Model for search inquiries and results

// Get all vehicles matching search criteria
function getSearch($searchStr){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = "SELECT inv.invId, invYear, invMake, invModel, invDescription, invPrice, invColor, classificationName, imgPath
            FROM inventory AS inv 
            INNER JOIN carclassification AS cc ON inv.classificationId = cc.classificationId 
            INNER JOIN images AS img ON inv.invId = img.invId 
            WHERE CONCAT(invYear,invMake,invModel,invDescription,invColor) LIKE CONCAT('%', :searchStr, '%')
            AND imgPath LIKE '%tn%'
            ORDER BY invModel ASC";
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace placeholders in SQL with actual variables, treats the invId as an interger
    $stmt->bindValue(':searchStr', $searchStr, PDO::PARAM_STR);
    $stmt->execute();
    // requesting an associative array
    $searchRes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //end db interaction
    $stmt->closeCursor();
    //return array
    return $searchRes; 
}


// get vehicles 11-20 in the $searchRes 
function getSearch2($searchStr, $limit1, $limit2){
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // the SQL statement
    $sql = "SELECT inv.invId, invYear, invMake, invModel, invDescription, invPrice, invColor, classificationName, imgPath
            FROM inventory AS inv 
            INNER JOIN carclassification AS cc ON inv.classificationId = cc.classificationId 
            INNER JOIN images AS img ON inv.invId = img.invId 
            WHERE CONCAT(invYear,invMake,invModel,invDescription,invColor) LIKE CONCAT('%', :searchStr, '%')
            AND imgPath LIKE '%tn%'
            ORDER BY invModel ASC
            LIMIT $limit1,$limit2";
    //create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace placeholders in SQL with actual variables, treats the invId as an interger
    $stmt->bindValue(':searchStr', $searchStr, PDO::PARAM_STR);
    $stmt->execute();
    // requesting an associative array
    $searchRes2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //end db interaction
    $stmt->closeCursor();
    //return array
    return $searchRes2; 
}
