<div id="grid">
<?php
	if (!isset($_SESSION))
		session_start();
	require_once('GamesInfo.class.php');
	$gi = new GamesInfo($_SESSION['id_game']);
	if ($gi->status() != "waiting")
	{
		$game = $gi->loadGame();
		if ($game != false)
		{
			$players = $game->getPlayers();
			$keys = array_keys($players);
			foreach ($keys as $key)
			{
				if ($key == $_SESSION['login'])
					$my_ships = $players[$key]->getShips();
				else
					$his_ships = $players[$key]->getShips();
			}
			//print_r($my_ships);
			for ($i = 0 ; $i < 100; $i++)
			{
				echo "<div>\n";
				for ($j = 0 ; $j < 150 ; $j++)
					echo "<div x=".$j." y=".$i."></div>";
				echo "</div>\n";
			}
			foreach ($my_ships as $ship)
				echo '<img id="'.$ship->getId().'" class="ship" style="-moz-transform:rotate('.$ship->getOrientation().'deg);-webkit-transform:rotate('.$ship->getOrientation().'deg);top:'.(($ship->getPosY() * 10)-(($ship->getWidth() / 2) * 10)).'px;left:'.(($ship->getPosX() * 10)-(($ship->getHeight() /2) * 10)).'px; width: '.$ship->getWidth().'; height: '.$ship->getHeight().';" src="'.$ship->getImg().'" />';
			foreach ($his_ships as $ship)
				echo '<img id="'.$ship->getId().'" class="ship" style="-moz-transform:rotate('.$ship->getOrientation().'deg);-webkit-transform:rotate('.$ship->getOrientation().'deg);top:'.(($ship->getPosY() * 10)-(($ship->getWidth() / 2) * 10)).'px;left:'.(($ship->getPosX() * 10)-(($ship->getHeight() /2) * 10)).'px; width: '.$ship->getWidth().'; height: '.$ship->getHeight().';" src="'.$ship->getImg().'" />';
		}
	}
?>
</div>
<?php include('interface/commandPannel.php'); ?>
