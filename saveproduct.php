<?php

//$_POST is an array, containing all the data from a form
//session_start is the function to start the session, as for saving data across all the site
//I don't know why is it here

session_start();

//include() function includes entirety of the connect.php
/*all of those variables ($a, $b etc) are for storing data from the form
it gets them throught the $_POST*/
/*for our purposes we need only the following variables: 'name', 'price', 'qty', 'qty_sold'; 'supplier' we will transform
into "category"; we will add "kitchen" as a boolean value (can be stored as a TINYINT(1) value type in the database).
*/

include('../connect.php');
$a = $_POST['product_name'];
$b = $_POST['category'];
$c = $_POST['price'];
$d = $_POST['kitchen'];
$e = $_POST['product_comment'];

// query
$sql = "INSERT INTO products (product_name,category,price,kitchen,product_comment) VALUES (:a,:b,:c,:d,:e)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e));
header("location: products.php");

?>
