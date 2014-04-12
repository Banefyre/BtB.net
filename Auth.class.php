<?PHP

require_once('ConnectDB.trait.php');

Class Auth
{
	use ConnectDB;
	public function __construct()
	{
	}

	public function userExist($user)
	{
		$mysqli = $this->connect();
		$req = $mysqli->query('SELECT * FROM `users` WHERE `login` = "'.$user.'" LIMIT 1');
		$ret = false;
		if ($req && $req = $req->fetch_assoc() && $req->num_rows)
			$ret = true;
		$mysqli->close();
		return $ret;
	}

	public function login($user, $pass)
	{
		$mysqli = $this->connect();
		$req = $mysqli->query('SELECT * FROM `users` WHERE `login` = "'.$user.'" AND `password` = "'.$this->hashcode($pass).'"LIMIT 1');
		$ret = false;
		if ($req && $req = $req->fetch_assoc() && $req->num_rows)
			$ret = true;
		$mysqli->close();
		return $ret;
	}

	public function register($user, $pass)
	{
		if ($this->userExist($user, $pass))
			return false;
		$mysqli = $this->connect();
		$req = $mysqli->query('INSERT INTO `users` SET `login` = "'.$user.'", `password` = "'.$this->hashcode($pass).'"');
		$ret = false;
		if ($req)
			$ret = true;
		$mysqli->close();
		return $ret;
	}

	private function hashcode($str)
	{
		return (hash('whirlpool', 'patate'.$str.'poire'));
	}

	public function redirect()
	{
		header('Location: server_list.php');
		exit();
	}


}

?>
