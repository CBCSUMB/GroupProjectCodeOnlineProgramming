<?php
	session_start();
	
	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
	}
	
	require 'db_connection.php';
	
	$team;
	$game;
	$opposingTeam;
	
	echo "<a href='index.php'>Back</a>";
	
	
	if (isset($_POST['imageUrl'])) {
		$sql = "UPDATE group_teams SET ImageUrl = :imageUrl WHERE TeamID = :teamId";
		$stmt = $dbConn -> prepare ($sql);
		$stmt -> execute( array (':imageUrl' => $_POST['imageUrl'], ':teamId' => $_GET['teamID']));
	}
	
	if(isset ($_GET['teamID'])) {
		$sql = "Select *
				FROM group_teams
				Where TeamID = :teamID ";
				
		$stmt = $dbConn -> prepare ($sql);
		$stmt -> execute( array (':teamID' => $_GET['teamID']));
		$team = $stmt->fetchAll();
		$team = $team[0];
		
		if ($team["TeamID"]%2 == 0) {
			$sql = "SELECT * FROM group_teams JOIN group_games ON group_teams.TeamID = group_games.Team2 WHERE TeamID = :teamID";
					
			$stmt = $dbConn -> prepare ($sql);				 
			$stmt -> execute( array (':teamID' => $team["TeamID"]));
			$game = $stmt->fetchAll();
			$game = $game[0];
			
			$sql = "SELECT * FROM group_teams WHERE TeamID = :teamID";
			$stmt = $dbConn -> prepare ($sql);				 
			$stmt -> execute( array (':teamID' => $game["Team1"]));
			$opposingTeam = $stmt->fetchAll();
			$opposingTeam = $opposingTeam[0];
		} else {
			$sql = "SELECT * FROM group_teams JOIN group_games ON group_teams.TeamID = group_games.Team1 WHERE TeamID = :teamID";
					
			$stmt = $dbConn -> prepare ($sql);				 
			$stmt -> execute( array (':teamID' => $team["TeamID"]));
			$game = $stmt->fetchAll();
			$game = $game[0];
			
			$sql = "SELECT * FROM group_teams WHERE TeamID = :teamID";
			$stmt = $dbConn -> prepare ($sql);				 
			$stmt -> execute( array (':teamID' => $game["Team2"]));
			$opposingTeam = $stmt->fetchAll();
			$opposingTeam = $opposingTeam[0];
		}
	} else {
		echo "No team";
	}
	
	echo "<h1>(" . $team["Seed"] . ") " . $team["TeamName"];
	echo "<img src='" . $team["imageUrl"] . "' />";
	
	echo "</h1>";
	
	if ($team["imageUrl"] == null) {
		echo "<form method='post'><input id='imageUrl' type='text' name='imageUrl' placeholder='Enter a team logo image URL'>";
	} else {
		echo "<form method='post'><input id='imageUrl' type='text' name='imageUrl' value='" . $team['imageUrl'] . "'>";
	}
	
	
	echo "<input type='submit' value='Update Image URL' /></form><br/>";
	
	echo "<h4>Division: " . $team["Division"] . "</h4><br/>";
	echo "Round of 32 game:<br/>";
	if ($team["TeamID"]%2 == 0) {
		if ($game["Score2"] > $game["Score1"]) {
			echo "<b>(" . $team["Seed"] . ") " . $team["TeamName"] . " " . $game["Score2"] . "</b> - " . "(" . $opposingTeam["Seed"] . ") " . $game["Score1"] . " " . $opposingTeam["TeamName"];
		} else {
			echo "(" . $team["Seed"] . ") " . $team["TeamName"] . " " . $game["Score2"] . " - " . "<b>(" . $opposingTeam["Seed"] . ") " . $game["Score1"] . " " . $opposingTeam["TeamName"] . "</b>";
		}	
	} else {
		if ($game["Score2"] > $game["Score1"]) {
			echo "(" . $team["Seed"] . ") " . $team["TeamName"] . " " . $game["Score1"] . " - " . "<b>(" . $opposingTeam["Seed"] . ") " . $game["Score2"] . " " . $opposingTeam["TeamName"] . "</b>";
		} else {
			echo "<b>(" . $team["Seed"] . ") " . $team["TeamName"] . " " . $game["Score1"] . "</b> - " . "(" . $opposingTeam["Seed"] . ") " . $game["Score2"] . " " . $opposingTeam["TeamName"];
		}	
	}
	
?>
<!DOCTYPE  html>
<html>
	<head>
		<title>Group Assignment: Jon Oikawa</title>
		<style>
			img {
				height: 50px;
				width: 50px;
			}
			
			#imageUrl {
				width: 25%;
			}
			
			body {
		  		background-color: #7BAFD4;
		  		font-family: "Lucida Sans Unicode";
		  	}
		</style>
		</style>
	</head>
	
</html>