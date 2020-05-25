<?php
session_start();
include('../connect.php');
$table = $_POST['table'];       //table No
$note = $_POST['note'];        //order note
$invoice = $_POST['invoice'];
$cashier = $_POST['cashier'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$sql = "INSERT INTO sales (invoice_number,cashier,date,amount) VALUES (:invoice,:cashier,:date,:amount)";
$query = $db->prepare($sql);
$query->execute(array(':invoice'=>$invoice,':cashier'=>$cashier,':date'=>$date,':amount'=>$amount));
header("location: preview.php?invoice=$invoice"."&table=".$table."&note=".$note);
exit();


?>
