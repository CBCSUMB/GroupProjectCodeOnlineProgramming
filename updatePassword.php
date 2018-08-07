<?
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
	}
	
	require 'db_connection.php';
	
	
	if (isset($_POST['save']) && !empty($_POST['password'])) { //checks whether we're coming from "save data" form
		
		$sql = "UPDATE group_admin SET password = :password WHERE username = :username";
		
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute(array (":password" => hash('sha1', $_POST['password']), ":username" => $_SESSION['username']));
		
		echo "Password updated. <br> <br>"; 
	}

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Group Assignment: Jon Oikawa</title>
		<style>
			body {
		  		background-color: #7BAFD4;
		  		font-family: "Lucida Sans Unicode";
		  	}
		</style>
	</head>
	
	<body>
		<div>		
			<form method="post">
				Password: <input type="password" name="password" /><br />
				<input type="submit" name="save" value="Save"> 
			</form>
				
		<a href="index.php"> Go back to main page </a>
	</div>
	</body>
</html>