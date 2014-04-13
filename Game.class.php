<?PHP
require_once("ConnectDB.trait.php");

Class Game
{
	use ConnectDB;
	private $_faction;
	private $_id = false;

	function __construct($name)
	{
		$mysqli = $this->connect();
		if ($mysqli->query("INSERT INTO game (name, max_players) VALUES ('".$name."', 2)") === FALSE)
			echo $mysqli->error;
		if (($res = $mysqli->query("SELECT id FROM game ORDER BY id DESC LIMIT 1")) === FALSE)
			echo $mysqli->error;
		else
		{
			$this->_id = $res->fetch_assoc()['id'];
			//$this->_id = $this->_id['id'];
		}
		if ($mysqli->query("INSERT INTO `games_faction` (`id_game`, `id_faction`, `selected`) VALUES
			(".intval($this->_id).", 1, 0),
			(".intval($this->_id).", 2, 0),
			(".intval($this->_id).", 3, 0);") === FALSE)
			echo $mysqli->error;

		$mysqli->close();
	}

	public function getId()
	{
		return $this->_id;
	}
}

?>
