<?php
	include('../connect.php');
	$id=$_GET['id'];
	$c=$_GET['invoice'];
	$deleteId=$_GET['dle'];

	$result = $db->prepare("DELETE FROM sold_items WHERE transaction_id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
	header("location: sales.php?id=$deleteId&invoice=$c");
?>
