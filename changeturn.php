<?PHP
require_once("GamesInfo.class.php");
session_start();
if(isset($_SESSION['id_game']))
{
	$gi = new GamesInfo($_SESSION['id_game']);
	$gi->changeTurn();
}
?>
