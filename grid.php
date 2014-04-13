<div id ="grid">
<?PHP
	if (!isset($_SESSION))
		session_start();
	require_once("GamesInfo.class.php");
	$gi = new GamesInfo($_SESSION['id_game']);
	if ($gi->status() != "waiting")
		$game = $gi->loadGame();
	for ($i = 0 ; $i < 100; $i++)
	{
		for ($j = 0 ; $j < 150 ; $j++)
		{
			echo "<div class='cell' x=".$j." y=".$i."></div>";
		}
	}
	echo '<div><img class="ship" src="images/chao_1.png" /></div>'
?>
</div>
<?PHP include('interface/commandPannel.php');?>

