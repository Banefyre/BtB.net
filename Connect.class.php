<?PHP

require_once("GamesInfo.class.php");

final Class Connect
{
	private $_id;
	private $_playersNumb;
	private $_gi;
	private $_ships;

	function __construct()
	{
		$this->_gi = new GamesInfo($_SESSION['id_game']);
		$this->_gi->connectPlayer();
		$this->chooseFaction();
	}

	private function chooseFaction()
	{
		$factions = $this->_gi->getFactions();
		echo "<div id='faction'>";
		echo "<h3>Choose a faction</h3>";
		foreach ($factions as $faction)
		{
			if ($faction['selected'])
				echo "<input class='selected' style='color : red' id='".$faction['id']."' type='submit' value='".$faction['name']."' />";
			else
				echo "<input class='faction' id='".$faction['id']."' type='submit' value='".$faction['name']."' />";
		}
		echo "</div>";
	}
}

?>
