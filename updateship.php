<?PHP
session_start();
require_once('GamesInfo.class.php');
if (isset($_POST['id']))
{
	$gi = new GamesInfo($_SESSION['id_game']);
	$game = $gi->loadGame();
	$players = $game->getPlayers();
	foreach ($players as $key)
	{
		if ($key->getName() == $_SESSION['login'])
			$my_ships = $key->getShips();
	}
	foreach ($my_ships as $ship)
	{
		if ($ship->getId() == $_POST['id'])
			$s = $ship;
	}
	$s->setBonusWeapon($_POST['weapon']);
	$s->setBonusShield($_POST['shield']);
	$s->setBonusSpeed($_POST['speed']);
	$s->setShell($s->getShell() + $_POST['shell']);
	$ser = serialize($game);
	echo $ser;
	$gi->saveGame($ser);
}
?>
