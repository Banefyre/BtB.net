<?PHP
trait ConnectDB
{
	private function connect()
	{
		$mysqli = new mysqli('localhost', 'root', 'password', 'game');
		return $mysqli;
	}
}
?>

