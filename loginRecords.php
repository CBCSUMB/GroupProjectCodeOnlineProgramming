<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
	}
	
	require 'db_connection.php';

	echo "<a href='index.php'>Back</a>";
	
	$sql = "SELECT * FROM group_login";
	
	$stmt = $dbConn -> prepare ($sql);				 
	$stmt -> execute();
	$logins = $stmt->fetchAll();
	
	echo "<h1>Login Records</h1>";
	
	foreach ($logins as $login) {
		echo "Username: " . $login['username'] . ".   Date/Time: " . $login['datetime'] . "<br/>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Group Assignment: Jon Oikawa</title>
		<style>
			form {
				display: inline;
			}
			
			body {
		  		background-color: #7BAFD4;
		  		font-family: "Lucida Sans Unicode";
		  	}
		</style>
	</head>
</html>


