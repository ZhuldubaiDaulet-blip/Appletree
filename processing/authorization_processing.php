<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);

// The function filtrates input string via encoded fuctions
function filtrateString($a_string)
{
	return htmlspecialchars(trim($a_string));
}

$login = filtrateString( $_POST['login']);
$password = filtrateString( $_POST['password']);

if (!empty($login) && !empty($password))
{
	// Fetch data to check according to the login
	$sql = "SELECT `login`, `pswd` FROM `appletree_personnel`.`admins` WHERE `login` = :login";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':login' => $login]);
	$user = $stmt->fetch(PDO::FETCH_OBJ);
	if($user)
	{
		if (password_verify($password, $user->pswd))
		{
			session_start();
			$_SESSION['user_login'] = $user->login;
			// This execution status means that the password corresponds to the login
			echo 0;
		} else
		{
			// This execution status means that the password does not correspond to the login
			echo 1;
		}
	} else
	{
		// This execution status means that query did not get any result, i.e. no record with such login
		echo 2;
	}
}
else
{
	// This execution status means that one or both variables were empty strings
	echo 3;
}
?>