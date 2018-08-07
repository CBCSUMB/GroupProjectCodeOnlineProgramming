<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
	}
	
	require 'db_connection.php';
	
	$teamData;
	
	function getDivision()
	{
		global $dbConn;
		
		$sql = "SELECT distinct Division
				FROM ncaa_teams
				ORDER BY Division asc";
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute();
		return $stmt->fetchAll();
	}
	
    echo "<h1>March Madness</h1>";
	echo "<b>Displaying: <br/>";
	
	
	$sql = "SELECT * FROM group_teams ";
	if(isset($_POST['division']) and $_POST['division'] != 'all') {
		echo "Division: " . $_POST['division'] . "<br/>";
		$sql .= "WHERE Division = :division ";
	} else {
		echo "Division: All<br/>";
	}
	
	if (isset($_POST['sort']) and $_POST['sort'] != 'none') {
		if ($_POST['sort'] == 'seed') {
			echo "Sorted by: Seed<br/>";
			$sql .= "ORDER BY Seed ASC";
		} else {
			echo "Sorted by: Points Scored<br/>";
			$sql .= "ORDER BY Points DESC";
		}
	} else {
		echo "Sorted by: None<br/>";
	}
	
	echo "</b><br/><br/>";
	
	if(isset($_POST['division']) and $_POST['division'] != 'all') {
		$stmt = $dbConn -> prepare ($sql);
		$stmt -> execute( array (':division' => $_POST['division']));
	} else {
		$stmt = $dbConn -> prepare ($sql);
		$stmt -> execute();
	}
	
	$teamData = $stmt->fetchAll();
	
	$sql = "SELECT MAX(Points) as Max, AVG(Points) as Avg FROM group_teams";
	$stmt = $dbConn -> prepare ($sql);
	$stmt -> execute();
	$points = $stmt->fetchAll();
	echo "Max points scored: " . $points[0]["Max"] . "<br/>";
	echo "Average points scored: " . $points[0]["Avg"] . "<br/><br/>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Group Assignment: Jon Oikawa</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
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
		Select Division:
		<select name="division">
			<?php
				
				$Divisions = getDivision();
				echo "<option value='all'>All</option>";
				foreach ($Divisions as $Division)
				{
					echo "<option value='" . $Division['Division'] . "' >" . $Division['Division'] . "</option>";
				}
			?>
	
		</select>  <br/>
		Display teams by: <br/>
		<input type="radio" checked = "checked" name="sort" value="none"/> None
		<input type="radio" name="sort" value="seed"/> Seed
		<input type="radio" name="sort" value="points"/> Points
		
		<input type="submit" value="Sort!">
	</form>	
	<div id="team-list">
		<? 
			foreach ($teamData as $team) {
				echo "<a href='team.php?teamID=" . $team['TeamID'] . "'>" . $team["Points"] . " - (" . $team['Seed'] . ") " . $team['TeamName'] . "</a><br/>";
			}
		?>
	</div>
	<hr>
	<a href="updatePassword.php">Update Password</a><br/>
	<a href="logout.php">Logout</a><br/><br/>
	<a href="loginRecords.php">Look at login records</a><br/>
    <a href="http://hosting.otterlabs.org/classes/oika5686/">Home</a>
  </div>
</body>
</html>