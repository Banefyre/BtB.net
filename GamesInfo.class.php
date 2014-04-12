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
}


?>
