<?PHP
include_once('ServersInfo.class.php');
$file = "private/passwd";
if (!file_exists($file))
{
?>
<html>
	<body>
Veuillez entrer vos infos de connextion a PhpMyAdmin afin de pouvoir installer la base de donnees sur votre machine : <br />
	<form action="sql/traitement.php" method="post">
	<input type="hidden" name ="etape" value="1" />
	<label for="login">Utilisateur :</label>
	<input type="text" name="login" maxlength="40" /><br />
	<label for="mdp">Mot de passe :</label>
	<input type="password" name="pwd" maxlength="40" /><br />
	<label for="submit">&nbsp;</label>
	<input type="submit" name="submit" value="Envoyer" />
	</form>
	</body>
</html>
<?PHP
}else{
	$serv =new ServersInfo();
	$array = $serv->getserverinfo();
	var_dump($array);
	echo "\n";
?>
<html>
	<body>
	Hello.
	</body>
</html>
<?PHP
}
?>
