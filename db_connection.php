<?php
	$dbname = 'oika5686';
	$username = 'oika5686';
	$password = 'da81d02a6e0970d';
	
	$dbConn = new PDO('mysql:host=localhost;dbname=oika5686', $username, $password);
	
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>