<?php 

require_once('functions.php');

connect();				//konekcija na bazu

$productId = $_GET['id'];			//id proizvoda iz URL
$imageNumber = $_GET['image'];		//broj proizvoda iz URL

$selectImageString = sprintf("SELECT %s FROM photo WHERE product=%s", $imageNumber, $productId);

//echo $selectImageString;

$selectImageQuery = mysql_query($selectImageString);

//echo $selectImageQuery;

$selectImageResult = mysql_fetch_array($selectImageQuery);

//echo $selectImageResult;


// after connecting to and reading the row from the table 
$image = $selectImageResult[0];
header("Content-type: image/png"); // or whatever 
echo $image; 
exit; 
?>