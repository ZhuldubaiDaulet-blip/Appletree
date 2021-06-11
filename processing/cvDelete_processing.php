<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
session_start();
// Block access for unathorized users
if (!isset($_SESSION['user_login'])) {
	header("Location:$authorizationPage_url");
}
// Terminate if the required arguments are not passed
if (!isset($_POST['id']) || !isset($_POST['role'])) {
	exit('False');
}

// Set the applicants table name
if ($_POST['role'] == 'teachers'){
	$tableName = '`appletree_personnel`.`teachers`';
	$sql = 'UPDATE `appletree_personnel`.`classes` SET `id_teacher` = NULL WHERE `id_teacher` = :id';
	$pdo->prepare($sql)->execute([':id' => $_POST['id']]);
}
elseif ($_POST['role'] == 'students')
	$tableName = 'appletree_personnel.students';
else
	exit('False');

// Deletion
$sql = 'DELETE FROM '.$tableName.' WHERE `id` = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $_POST['id']]);
exit(0);
?>