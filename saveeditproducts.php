<?php

include('../connect.php');

// add all the edited data about products from editproduct.php
$prodId =           $_POST['productIdentifier'];
$prodName =         $_POST['productName'];
$prodComm =         $_POST['comment'];
$prodKitchenorBar = $_POST['kitchen'];
$prodPrice =        $_POST['price'];
$prodCateg =        $_POST['category'];

// query

$editQuery = "UPDATE products
    SET product_name=?, product_comment=?, kitchen=?, price=?, category=?
		WHERE product_id=?";

// execute the query

$q = $db->prepare($editQuery);
$q->execute(array($prodName,$prodComm,$prodKitchenorBar,$prodPrice,$prodCateg,$prodId));
header("location: products.php");

?>
