<?PHP
session_start();
require_once("Chat.class.php");

$chat = new Chat();
if (isset($_POST['message']))
{
	$chat->addMessage($_POST['message']);
}

if (isset($_POST['update']))
{
	echo json_encode($chat->getMessages());
}

?>
