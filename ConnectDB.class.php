<?PHP
class ConnectDB {

	protected $_mysqli;
	private $_host = 'localhost';
	private $_user = 'root';
	private $_db = 'game';
	private $_pass;

	public function __construct() {
		$this->_pass = file_get_contents("private/passwd");
		$this->DBClass($this->_db, $this->_user, $this->_pass);
	}

	private function DBClass($dbname, $username, $password) {
	$this->_mysqli = mysqli_connect('localhost', $username, $password, $this->_db);
	if (!$this->_mysqli)
		die ("Unable to connect to Database Server");
	}

	public function __get( $_mysqli) {
		return ($_mysqli);
	}
}
?>
