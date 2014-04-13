<?PHP
session_start();
require_once("GamesInfo.class.php");
if (isset($_SESSION['id_game']))
{
	$gi = new GamesInfo($_SESSION['id_game']);
	$gi->disconnect($_SESSION['login']);
	unset($_SESSION['id_game']);
}
header('Location: server_list.php');
?>
