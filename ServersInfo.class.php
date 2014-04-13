<?PHP
require_once('ConnectDB.trait.php');

class ServersInfo
{
	use ConnectDB;
	private $_servers = array();

	public function __construct()
	{
		$this->getdatafromdb();
	}

	private function getPlayersByGame($mysqli,$id)
	{
		$array = array();
		$data = $mysqli->query("SELECT `id_user` FROM `games_players` WHERE `id_game` = ".$id);
		while ($id_player = $data->fetch_assoc())
		{
			$array[] = $id_player["id_user"];
		}
		return($array);
	}

	private function getdatafromdb()
	{
		$mysqli = $this->connect();
		$req = $mysqli->query("SELECT * FROM `game` WHERE `status` != 'finished' ORDER BY `id` ASC");
		while (($res = $req->fetch_assoc()))
		{
			$players = $this->getPlayersByGame($mysqli,$res['id']);
			$res['player_connected'] = count($players);
			$this->_servers[] = $res;
		}
		$mysqli->close();
	}

	public function getServersInfo()
	{
		return ($this->_servers);
	}

}
?>
