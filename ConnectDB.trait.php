<?PHP
trait ConnectDB
{
		private function connect()
	{
		$host = 'localhost';
		$user = 'root';
		$db = 'game';
		$pass = file_get_contents("private/passwd");
		$mysqli = new mysqli($host, $user, $pass, $db);
		return $mysqli;
	}
}
?>

