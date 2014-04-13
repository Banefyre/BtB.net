<!DOCTYPE html>
<html>
	<head>
		<title>Rush01</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/grid.css" />
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="js/server_list.js"></script>
	</head>
	<body>
		<div id="bar">
			<a href="logout.php">logout</a>
		</div>
		<div id="box">
			<div id="content">
<?php
session_start();
require_once('Connect.class.php');
require_once('Server.class.php');
require_once('GamesInfo.class.php');
if (!isset($_SESSION['id_game'])) //connect to game or create game
{
	if (isset($_POST['status']))
	{
		if ($_POST['status'] == "connect" && isset($_POST['id_game']))
		{
			//echo "You are connected to game number : ".$_POST['id_game'];
			connectToGame($_POST['id_game']);
		}
		else if ($_POST['status'] == "create" && isset($_POST['game_name']))
		{
			if ($_POST['game_name'] !== "")
			{
				//echo "Create new game : ".$_POST['game_name'];
				createGame($_POST['game_name']);
			}
			else
			{
				header('Location: ./server_list.php?error=name');
				exit();
			}
		}
	}
}
else //connected to game
{
	$gi = new Gamesinfo($_SESSION['id_game']);
	if (!empty($_POST['faction']))
	{
		$_SESSION['viewFactions'] = "<div id=\"faction\" game=\"true\"></div>";
		$_SESSION['game_started'] = true;
		$gi->setFaction($_POST['faction']);
	}

	if (isset($_SESSION['game_started']))
		include('grid.php');
}

function connectToGame($id)
{
	$_SESSION['id_game'] = $id;
	$game = new Connect();
	//$_SESSION['game'] = $game->getInfo();
}

function createGame($name)
{
	$new = new Server($name);
	$_SESSION["id_game"] = $new->getId();
	$game = new Connect();
}
?>
			</div>
<?=$_SESSION['viewFactions']; ?>
			<input id="choose" type="button" value="Choose a faction" />
			<form id="disconnect" action="disconnect.php" method="post">
				<input type="submit" value="Disconnect" />
			</form>
		</div>
		<script src="js/game.js"></script>
	</body>
</html>
