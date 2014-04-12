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

	private function getdatafromdb()
	{
		$mysqli = $this->connect();
		$req = $mysqli->query("SELECT * FROM `game` ORDER BY `id` ASC");
		while (($res = $req->fetch_assoc()))
		{
			$res['player_connected'] = 1;
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
