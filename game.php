<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
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
			echo "You are connected to game number : ".$_POST['id_game'];
			connectToGame($_POST['id_game']);
		}
		else if ($_POST['status'] == "create" && isset($_POST['game_name']))
		{
			if ($_POST['game_name'] !== "")
			{
				echo "Create new game : ".$_POST['game_name'];
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
$.ajax({
	url : 'status.php',
	method: 'POST',
	data : { update : 'update' },
	success : function(res) {
		res = res.trim();
		console.log(res);
		if (res == "waiting")
			$('#game_status').text("Waiting for player to connect since " + i + " seconds");
		else if (res == "<?PHP echo $_SESSION['login'];?>")
			$('#game_status').text("It\'s your turn !");
		else if (res == "finished")
		{
			$('#game_status').text("The other player disconnected, you won !");
			setTimeout(function() {
				window.location.replace("disconnect.php");
			}, 5000);
		}
		else
			$('#game_status').text("It\'s "+res+" turn, wait a min :)");
	}
	});
}, 1000);

</script>
<form method='POST' action='disconnect.php'>
<input type="submit" value="Disconnect" />
</form>
</body>
</html>
