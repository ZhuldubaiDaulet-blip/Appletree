<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
session_start();
// Block access for unathorized users
if (!isset($_SESSION['user_login'])) {
	header("Location:$authorizationPage_url");
}
// Redirect if the required argument is not passed
if (!isset($_POST['temp']) || is_null($_POST['temp'])) {
	header("Location:$adminIndex_url");
}

switch ($_POST['temp']) {
	case 'applications':
		echo $appInject_url;
		break;
	case 'schedule':
		echo $schInject_url;
		break;
	case 'members':
		echo $memInject_url;
		break;
	case 'classes':
		echo $clsInject_url;
		break;
	case 'frontEdit':
		echo $edtInject_url;
		break;
	default:
		// If could not find the corresponding file
		exit('False');
		break;
}
exit;