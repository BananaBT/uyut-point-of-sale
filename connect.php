<?php
/* Database configuration parameters are specified by your hosting provider, if you deploy it on your local machine, the user will be something like 'root' etc. */
$db_host		= 'localhost';
$db_user		= '';
$db_pass		= '';		
$db_database	= '';

$db = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
