<?php
session_start();
require_once('ServersInfo.class.php');
$servinfo = new ServersInfo();
$servers = $servinfo->getServersInfo();
if (!isset($_SESSION['login']))
	header('Location: index.php');
if (isset($_SESSION['id_game']))
	header('Location: game.php');

$chat_list = "<div>
\t\t\t\t\t<div><div>Arubinu</div>Je ne fais rien qu'un test, un simple test pour ce rush qui avance plut&ocirc;t bien ^^</div>
\t\t\t\t\t<div><div>Paul</div>Ok ta gueule</div>
\t\t\t\t\t<div><div>Paul</div>Ooups Excuse</div>
\t\t\t\t\t<div><div>Arubinu</div>...</div>
\t\t\t\t</div>\n";
$server_list = '';
foreach ($servers as $serv)
{
	$connect = "
\t\t\t\t\t\t<form action=\"game.php\" method=\"post\">
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"id_game\" value=\"".$serv['id']."\" />
\t\t\t\t\t\t\t<input class=\"input_connect\" name=\"status\" type=\"submit\" value=\"connect\" />
\t\t\t\t\t\t</form>\n\t\t\t\t\t";
	$server_list .= (empty($server_list) ? '' : "\t\t\t\t")."<div>\n";
	$server_list .= "\t\t\t\t\t<div class=\"server\">".$serv['name']."</div>\n";
	$server_list .= "\t\t\t\t\t<div class=\"players\">".$serv['player_connected']."/".$serv['max_players']."</div>\n";
	$server_list .= "\t\t\t\t\t<div class=\"connect".(($serv['player_connected'] >= $serv['max_players']) ? ' full">Full' : '">'.$connect)."</div>\n\t\t\t\t</div>\n";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rush01</title>
		<link rel="stylesheet" type="text/css" href="css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/connect.css" />
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="js/server_list.js"></script>
	</head>
	<body>
		<div id="bar">
			<a href="logout.php">logout</a>
		</div>
		<div id="box">
			<div class="chatbox">
				<?=$chat_list; ?>
			</div>
			<div class="serverbox">
				<?=$server_list; ?>
				<div class="form">
					<form action="game.php" method="post">
						<label>Game name</label>
						<input type="text" name="game_name" />
						<input type="submit" value="create" name="status" />
					</form>
				</div>
			</div>
			<br />
			<div class="talkbox">
				<textarea id="talk"></textarea>
			</div>
		</div>
	</body>
</html>
