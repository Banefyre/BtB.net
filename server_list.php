<html>
<head>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="js/server_list.js"></script>
</head>
<body>
<?PHP
require_once("ServersInfo.class.php");
$servinfo = new ServersInfo();
$servers = $servinfo->getServersInfo();
if (isset($_SESSION['id_game']))
	unset($_SESSION['id_game']);
?>
<table border="1">
<?PHP
foreach ($servers as $serv)
{
	echo "<tr>";
	if ($serv['player_connected'] == $serv['max_players'])
		echo "<td>id :".$serv['id']."</td><td>name : ".$serv['name']."</td><td>players: ".$serv['player_connected']."/".$serv['max_players']."</td><td>Full</td></tr>";
	else
		echo "<td>id :".$serv['id']."</td><td>name : ".$serv['name']."</td><td>players: ".$serv['player_connected']."/".$serv['max_players']."</td><td><form action='game.php' method='post'><input type='hidden' name='id_game' value='".$serv['id']."'><input class='input_connect' name='status' type='submit' value='connect'></form></tr>";
	echo "</tr>";
}

?>
</table>
<form method='post' action="game.php">
	Game name : <input type="text" name="game_name">
	<input type="submit" value="create" name="status">
</form>
</body>
</html>
