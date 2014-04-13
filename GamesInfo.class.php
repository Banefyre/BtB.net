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
		if (($id = $mysqli->query("SELECT `id` FROM `users` WHERE `login` = '".$_SESSION['login']."'")) === false)
			echo $mysqli->error;
		else
			$id = $id->fetch_assoc()['id'];

		if (($res2 = $mysqli->query("INSERT INTO `games_players` (id_game, id_user)  VALUE (".intval($this->_idGame).", ".intval($id).")")) === false)
			echo $mysqli->error;

		if (($nb = $mysqli->query("SELECT * FROM `games_players` WHERE `id_game` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
		{
			$nb = $nb->fetch_all();
			$nb = count($nb);
		}

		if (($nbmax = $mysqli->query("SELECT `max_players` FROM `game` WHERE `id` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
			$nbmax = $nbmax->fetch_assoc()['max_players'];

		if ($nb == $nbmax)
			$mysqli->query("UPDATE `game` SET `status` = '".$_SESSION['login']."' WHERE `id` = ".intval($this->_idGame));
		$mysqli->close();
	}

	public function disconnect($login)
	{
		$mysqli = $this->connect();
		if (($id = $mysqli->query("SELECT `id` FROM `users` WHERE `login` = '".$_SESSION['login']."'")) === false)
			echo $mysqli->error;
		else
			$id = $id->fetch_assoc()['id'];

		$mysqli->query("DELETE FROM `games_players` WHERE `id_user` = ".intval($id)." AND `id_game` = ".intval($this->_idGame));
		$mysqli->query("UPDATE `game` SET `status` = 'finished' WHERE `id` = ".intval($this->_idGame));
		$mysqli->close();
	}

	public function changeTurn()
	{
		$result = array();
		$mysqli = $this->connect();
		if (($status = $mysqli->query("SELECT `status` FROM `game` WHERE `id` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		$status = $status->fetch_assoc()['status'];
		if (($res = $mysqli->query("SELECT `users`.`login` FROM `users` INNER JOIN `games_players` ON `users`.`id` = `games_players`.`id_user` WHERE `games_players`.`id_game` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		while ($tmp = $res->fetch_assoc())
		{
			if ($tmp['login'] != $status)
			{
				$mysqli->query("UPDATE `game` SET `status` = '".$tmp['login']."' WHERE `id` = ".intval($this->_idGame));
			}
		}

		$mysqli->close();
	}
}

?>
