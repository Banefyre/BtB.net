<?PHP
trait ConnectDB
{
	private $_host = 'localhost';
	private $_user = 'root';
	private $_db = 'base';
	private $_pass = file_get_contents("private/passwd");
	private function connect($dbname, $username, $password)
	{
		$_pass = file_get_contents("private/passwd");
		$mysqli = new mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
	}
	private function disconnect()
	{
		mysqli::close();
	}
}
?>

