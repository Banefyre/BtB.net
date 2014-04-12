<?PHP
trait ConnectDB
{
	private function connect($dbname, $username, $password)
	{
		mysqli::__construct('localhost', $username, $password, $dbname);
	}

	private function disconnect()
	{
		mysqli::close();
	}
}
?>

