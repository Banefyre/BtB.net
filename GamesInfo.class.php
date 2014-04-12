<?PHP

include_once('ConnectDB.trait.php');

class GamesInfo
{
	use ConnectDB;
	private $_idGame;

	public function __construct($id)
	{
		$this->_idGame = $id;
	}

	public function getFactions()
	{
		$result = array();
		$mysqli = $this->connect();
		if (($res = $mysqli->query("SELECT `faction`.`name`, `games_faction`.`selected`, `games_faction`.`id` FROM `game` INNER JOIN `games_faction` ON `games_faction`.`id_game` = `game`.`id` INNER JOIN `faction` ON `faction`.`id` = `games_faction`.`id_faction` WHERE `game`.`id` = ".intval($this->_idGame)." ORDER BY `faction`.`name` ASC")) === false)
			echo $mysqli->error;
		while ($tmp = $res->fetch_assoc())
		{
			$result[] = $tmp;
		}
		$mysqli->close();
		return($result);
	}

	public function setFaction($id)
	{
		$mysqli = $this->connect();
		if (($res = $mysqli->query("UPDATE `games_faction` SET `selected` = '1' WHERE `games_faction`.`id` = ".intval($id))) === false)
			echo $mysqli->error;
		$mysqli->close();
	}

	public function status()
	{
		$mysqli = $this->connect();
		if (($res = $mysqli->query("SELECT `status` FROM `game` WHERE id = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
			$ret = $res->fetch_assoc();
		$mysqli->close();
		return($ret['status']);
	}

	public function connectPlayer()
	{
		$mysqli = $this->connect();
		if (($id = $mysqli->query("SELECT `id` FROM `users` WHERE `name` = '".$_SESSOIN['login']."'")) === false)
			echo $mysqli->error;
		else
			$id = $res->fetch_assoc()['id'];

		if (($res2 = $mysqli->query("INSERT INTO `games_player` (id_game, id_user)  VALUE (".intval($this->_idGame).", ".intval($id).")")) === false)
			echo $mysqli->error;

		if (($nb = $mysqli->query("SELECT * FROM `games_player` WHERE `id_game` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
		{
			$nb = $res->fetch_all();
			$nb = count($res);
		}

		if (($nbmax = $mysqli->query("SELECT `max_player` FROM `game` WHERE `id` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
			$nbmax = $res->fetch_assoc()['max_player'];

		if ($nb == $nb_max)
			$mysqli->query("UPDATE `game` SET `status` = `".$_SESSION['login']." ` WHERE `id` = '".intval($this->_idGame]));
		$mysqli->close();
	}
}


?>
