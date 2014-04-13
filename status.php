<?PHP
session_start();
require_once("GamesInfo.class.php");
if (isset($_POST['update']))
	{
	$gi = new Gamesinfo($_SESSION['id_game']);
	if($gi->status() === $_SESSION['login'])
		echo "my_turn";
	else
		echo $gi->status();
}
?>
