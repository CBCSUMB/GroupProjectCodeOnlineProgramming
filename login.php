<?php
	session_start();
	
	if (isset($_POST['username'])) {
		require 'db_connection.php';
		
		$sql = "SELECT * FROM group_admin WHERE username = :username AND password = :password";
		
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute(array(":username" => $_POST['username'], ":password" => hash("sha1", $_POST['password'])));
		
		$record = $stmt -> fetch();
		
		if (empty($record)) {
			echo "Wrong username/password combination.";
		} else {
			$_SESSION['username'] = $record['username'];
			$_SESSION['name'] = $record['firstname'] . " " . $record['lastname'];
			
			
			$sql = "INSERT INTO group_login (datetime, username) VALUES (:datetime, :username)";
			
			$stmt = $dbConn -> prepare($sql);
			$stmt -> execute(array(":datetime" => date("y-m-d") . " " . date("h:i:sa"),":username" => $_POST['username']));
						
			header("Location: index.php");
		}
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
		
		<script>
			function confirmLogout(event) {
				var logout = confirm("Do you really want to log out?");
				if (!logout) {
					event.preventDefault();
				}	
			}
			
		</script>
	</head>
	<body>
		<div>
			<h1>Login</h1>			
			<form method="post">
				Username: <input type="text" name="username" /><br/><br/>
				Password: <input type="password" name="password" /><br/><br/>
				<input type="submit" value="login" /><br/>
			</form>
			<p>
				Username: oika5686<br/>
				Password: password
			</p>
		</div>
	</body>
	
</html>

