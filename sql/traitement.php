<?php

function write_login($passwd)
{
	$file = "../private/passwd";
	if (!file_exists("../private"))
		mkdir("../private");
	file_put_contents($file,$passwd);
	return 1;
}

if(isset($_POST['etape']) && $_POST['etape'] == 1)
{
	define('OK', '<span class="ok">OK</span><br />');
	$host = "localhost";
	$login = trim($_POST['login']);
	$pwd = trim($_POST['pwd']);
	$base = "base";
	$dbh = mysqli_init();
	$link = mysqli_real_connect($dbh,$host,$login,$pwd);
	$sql = file_get_contents('base.sql');
	mysqli_multi_query($dbh,$sql);
	write_login($pwd);
	header('Location: ../index.php');
}
else
		exit('Vous devez d\'abord être passé par <a href="../install.php">le formulaire</a>.');
?>
