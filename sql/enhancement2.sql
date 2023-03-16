INSERT into clients
    (clientId,
    clientFirstname, 
    clientLastname,
    clientEmail,
    clientPassword,
    comment)
 VALUES
    (null,
    'Tony',
    'Stark',
    'tony@starknet.com',
    'Iam1ronM@n',
    "I am the real Ironman");

UPDATE clients
SET clientLevel = 3
WHERE clientId = 2;

UPDATE inventory
SET invDescription = REPLACE(invDescription,'small interiors','spacious interiors')
WHERE invId = 12;

SELECT invModel
FROM inventory i
INNER JOIN carclassification c
WHERE i.classificationId = 1
AND c.classificationId = 1;

DELETE FROM inventory
WHERE invID = 1;

UPDATE inventory
SET invImage = concat('/phpmotors',invImage),
	invThumbnail = concat('/phpmotors',invThumbnail);

