<?PHP
session_start();
if (isset($_SESSION['login']))
	header('Location: server_list.php');

require_once("Auth.class.php");
$error = false;
if (!empty($_POST['login']))
{
	$auth = new Auth();
	if (!empty($_POST['password2']))
	{
		if ($_POST['password'] === $_POST['password2'])
		{
			if ($auth->register($_POST['login'], $_POST['password']))
			{
				$_SESSION['login'] = $_POST['login'];
				$auth->redirect();
			}
		}
		$error = true;
	}
	else
	{
		if ($auth->login($_POST['login'], $_POST['password']))
		{
			$_SESSION['login'] = $_POST['login'];
			$auth->redirect();
		}
		$error = true;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Rush01</title>
		<link rel="stylesheet" type="text/css" href="css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/auth.css" />
	</head>
	<body>
		<div id="bar">
			<a href="#login">bienvenue</a>
		</div>
		<div id="box">
			<div class="minibox">
				<label>Connexion</label>
				<form method="post">
					<input type="text" name="login" placeholder="login de connexion" />
					<br />
					<input type="password" name="password" placeholder="mot de passe" />
					<br />
					<input type="submit" value="Envoyer"<?PHP echo $error ? ' class="login_error"' : ''; ?>/>
				</form>
			</div>
			<div class="minibox">
				<label>Inscription</label>
				<form method="post">
					<input type="text" name="login" placeholder="login de connexion" />
					<br />
					<input type="password" name="password" placeholder="mot de passe" />
					<br />
					<input type="password" name="password2" placeholder="verifier mot de passe" />
					<br />
					<input type="submit" value="Envoyer"<?PHP echo $error ? ' class="login_error"' : ''; ?>/>
				</form>
			</div>
		</div>
	</body>
</html>
