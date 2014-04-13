<?php
session_start();
require_once('ServersInfo.class.php');
$servinfo = new ServersInfo();
$servers = $servinfo->getServersInfo();
if (!isset($_SESSION['login']))
	header('Location: index.php');
if (isset($_SESSION['id_game']))
	header('Location: game.php');

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
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
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
			<div class="chatbox"></div>
			<div class="serverbox">
				<div>
					<div class="server">Name</div>
					<div class="players">Plr.</div>
					<div class="connect"></div>
				</div>
				<span id="server_list">
				<?=$server_list; ?>
				</span>
				<div class="form">
					<form action="game.php" method="post">
						<input type="text" name="game_name" placeholder="<?php echo (!empty($_GET['error']) && $_GET['error'] == 'name') ? 'Game Name Error' : 'New Game Name'; ?>" />
						<input type="submit" value="create" name="status" />
						<input type="button" value="refresh" id="refresh" />
					</form>
				</div>
			</div>
			<br />
			<div class="talkbox">
				<input type="text" id="talk" />
			</div>
		</div>
	</body>
</html>
