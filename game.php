<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="js/game.js"></script>
	<link href="css/grid.css" rel="stylesheet" type="text/css"/>
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

	$gi = new Gamesinfo($_SESSION['id_game']);
	if (!empty($_POST['faction']))
	{
		$_SESSION['game_started'] = true;
		$gi->setFaction($_POST['faction']);
	}
	if (isset($_SESSION['game_started']) && $_SESSION['game_started'] === true)
	{
		include("grid.php");
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
<script>
var i = 0;
setInterval(function (){
i++;
console.log("test");
<?PHP
$status = $gi->status();
if ($status == "waiting")
{
?>
	$('#game_status').text("waiting for player to connect since " + i + " sec");
<?PHP
}
?>
},1000);

</script>
</body>
</html>
