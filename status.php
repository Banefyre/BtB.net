<?PHP
session_start();
require_once("GamesInfo.class.php");
if (isset($_POST['update']))
	{
	$gi = new Gamesinfo($_SESSION['id_game']);
	echo (($gi->status()));
}
?>
