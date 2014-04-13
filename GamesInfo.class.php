<?PHP

include_once('ConnectDB.trait.php');
include_once('class/Game.class.php');

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
		{
			$mysqli->query("UPDATE `game` SET `status` = '".$_SESSION['login']."' WHERE `id` = ".intval($this->_idGame));
			$mysqli->close();
			$this->createGame();
		}
		else
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

	public function createGame()
	{
		$mysqli = $this->connect();
		if (($res = $mysqli->query("SELECT `users`.`login` FROM `users` INNER JOIN `games_players` ON `users`.`id` = `games_players`.`id_user` WHERE `games_players`.`id_game` = ".intval($this->_idGame))) === false)
			echo $mysqli->error;
		else
		{
			while ($tmp = $res->fetch_assoc())
			$result[] = $tmp;
		}

		$game = new Game(array(	'width' => 150,
		'height' => 100));


		$p1 = new Player(array('name' => $result[0]['login']));
		$p2 = new Player(array('name' => $result[1]['login']));
		$spear = new NavalSpear();
		$fregate1 = new Frigate(array(	'name' => 'Hand Of The Emperor',
			'weapons' => array($spear)));
		$fregate1->setPos(1,1, Ship::ORIENTATION_EAST);
		$fregate2 = new Frigate(array(	'name' => 'Black Rock',
			'weapons' => array($spear)));
		$fregate2->setPos(1,3, Ship::ORIENTATION_EAST);
		$fregate3 = new Frigate(array(	'name' => 'Hand Of The Emperor',
			'weapons' => array($spear)));
		$fregate3->setPos(145, 98, Ship::ORIENTATION_WEST);
		$p1->addShip($fregate1);
		$p1->addShip($fregate2);
		$p2->addShip($fregate3);
		$game->addPlayer($p1);
		$game->addPlayer($p2);
		$ser = serialize($game);


		if ($mysqli->query("UPDATE `game` SET `info` = '".$ser."' WHERE `id` = ".intval($this->_idGame)) === false)
			echo $mysqli->error;
		$mysqli->close();
		//$game->init();
	}

	public function loadGame()
	{
		$mysqli = $this->connect();

		if (($res = $mysqli->query("SELECT `info` FROM `game` WHERE `id` = '".intval($this->_idGame)."'")) === false)
			echo $mysqli->error;
		else
			$res = $res->fetch_assoc()['info'];
		$ser = unserialize($res);
		$mysqli->close();
		return ($ser);
	}
}

?>
