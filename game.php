<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="js/game.js"></script>
</head>
<body>
<div id=content>
<?PHP
session_start();
require_once("Connect.class.php");
require_once("Game.class.php");
require_once("GamesInfo.class.php");
if (!isset($_SESSION['id_game'])) //connect to game or create game
{
	if (isset($_POST['status']))
	{
		if ($_POST['status'] == "connect" && isset($_POST['id_game']))
		{
			echo "connect to game id : ".$_POST['id_game'];
			connectToGame($_POST['id_game']);
		}
		else if ($_POST['status'] == "create" && isset($_POST['game_name']))
		{
			if ($_POST['game_name'] !== "")
			{
				echo "create new game : ".$_POST['game_name'];
				createGame($_POST['game_name']);
			}
			else
				echo "You must write a game name";
		}
	}
}
else //connected to game
{
	if (!empty($_POST['faction']))
	{
		$gi = new Gamesinfo($_SESSION['id_game']);
		$gi->setFaction($_POST['faction']);
	}
}

function connectToGame($id)
{
	$_SESSION['id_game'] = $id;
	$game = new Connect();
	//$_SESSION['game'] = $game->getInfo();
}

function createGame($name)
{
	$new = new Game($name);
	$_SESSION["id_game"] = $new->getId();
	$game = new Connect();
}

?>
</div>
</body>
</html>
