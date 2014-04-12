<?PHP
include_once('ConnectDB.trait.php');

class ServersInfo {

	USE ConnectDB;
	private $_servers = array();

	public function __construct() {
		$this->getdatafromdb();
	}

	public function getdatafromdb(){
		$game_data = mysqli_query($this->_mysqli, "SELECT * FROM `game`");
		while($games = mysqli_fetch_array($game_data, MYSQLI_ASSOC))
		{
			array_push($this->_servers, $games);
		}
	}
	public function getserverinfo() {
		return ($this->_servers);
	}

}
?>
