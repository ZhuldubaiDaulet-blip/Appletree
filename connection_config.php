<?php
	// Variables required for extablishing the connection
	$driver = 'mysql';
	$host = '127.0.0.1';
	$username = 'root';
	$password = '';
	$appletree_general = 'appletree_general';
	$appletree_personnel = 'appletree_personnel';
	$appletree_schedule = 'appletree_schedule';
	$charset = 'utf8';
	// PDO options
	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

	// Session setting to destroy it immediately after user closes browser
	session_set_cookie_params(0);

	try
	{
		$pdo = new PDO("$driver:host=$host;dbname=$appletree_general;charset=$charset", $username, $password, $options);
	}
	catch (PDOException $e)
	{
		exit('Connection failed: ' . $e->getMessage());
	}
?>