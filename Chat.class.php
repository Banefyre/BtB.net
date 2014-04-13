<?PHP
require_once("ConnectDB.trait.php");

class Chat
{
	use ConnectDB;

	public function addMessage($message)
	{
		date_default_timezone_set("CET");
		$mysqli = $this->connect();
		if ($mysqli->query('INSERT INTO `chat` SET `login` = "'.$_SESSION['login'].'", `time` = "'.date("Y-m-j H:i:s").'", `message` = "'.$message.'"') === false)
			echo $mysqli->error;
		$mysqli->close();
	}

	public function getMessages()
	{
		$result = array();
		$mysqli = $this->connect();
		if (($res = $mysqli->query('SELECT login, message FROM `chat` ORDER BY `id` DESC LIMIT 23')) === false)
			echo $mysqli->error;
		while ($tmp = $res->fetch_assoc())
		{
			$result[] = $tmp;
		}
		return (array_reverse($result));
		$mysqli->close();

	}
}


?>
