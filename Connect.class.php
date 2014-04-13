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
		$_SESSION['viewFactions'] = "\t\t\t<div id=\"faction\" game=\"".((isset($_SESSION['game_started']) && $_SESSION['game_started']) ? 'true' : 'false')."\">\n";
		foreach ($factions as $faction)
			$_SESSION['viewFactions'] .= "\t\t\t\t<img src=\"images/factions/".strtolower($faction['name']).".jpg\" id=\"".$faction['id']."\" class=\"".($faction['selected'] ? 'false' : 'true')."\" />";
		$_SESSION['viewFactions'] .= "\t\t\t</div>";
	}
}

?>



