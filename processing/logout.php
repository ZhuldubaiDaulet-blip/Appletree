<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($connection_config);
session_start();
// Unset session variables
$_SESSION = array();
// Unset Cookies
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-1, '/');
}
// Destroy the session
session_destroy();
// Redirect to authorization page
$authorizationPage_url = $general_url . 'authorization_page.php';
header("Location:$authorizationPage_url");
?>