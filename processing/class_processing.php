<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
session_start();
// Block access for unathorized users
if (!isset($_SESSION['user_login'])) {
	header("Location:$authorizationPage_url");
}
// Terminate if the required argument is not passed
if (!isset($_POST['id'])) {
	exit('False');
}

try {
	// Input validation
	if (mb_strlen($_POST['name'])>100)
		throw new Exception('Characters limit for the class name is exceeded! Length is: '.mb_strlen($_POST['name']), 1);

	if ($_POST['action']=='delete') { // Deletion
		// Validate class id just in case
		$_POST['id'] = is_valid(filtrateString($_POST['id']),'^([GP]R|SP)[MBEPIUA]-[0-9]{1,9}$');
		$stmt = $pdo->prepare('UPDATE `appletree_personnel`.`students` SET `id_class` = null WHERE `id_class` = :id');
		$stmt->execute([':id' => $_POST['id']]);
		$stmt = $pdo->prepare('DELETE FROM `appletree_personnel`.`classes` WHERE `id` = :id');
		$stmt->execute([':id' => $_POST['id']]);
		exit (0);
	} elseif ($_POST['action']=='update') { // Update
		// Validating input
		$_POST['class_number'] = is_valid(filtrateString($_POST['class_number']), '^[0-9]{1,9}$');
		// Formatting the new class id
		$id = $_POST['group_ls'] . substr($_POST['ed_lvl'], 0, 1) . '-' . $_POST['class_number'];
		$name = ($_POST['name'] =='')? $id : $_POST['name'];
		$id_teacher = ($_POST['id_teacher'] =='')? null : $_POST['id_teacher'];

		// Calcucating number of students in the class
		$stmt = $pdo->prepare('SELECT COUNT(`id`) FROM `appletree_personnel`.`students` WHERE `id_class` = :id_class');
		$stmt->execute([':id_class' => $_POST['id']]);
		$std_num = ($std_num = $stmt->fetchColumn())? $std_num : 0;
		
		// Check if the class already exists (by id)
		$stmt = $pdo->prepare('SELECT EXISTS( SELECT `id` FROM `appletree_personnel`.`classes` WHERE `id` = :id )');
		$stmt->execute([':id' => $id]);
		if ($stmt->fetchColumn()) // If the class exists
		{	
			// If it has to be a new record (new class)
			if ($_POST['id']=='' || $_POST['id']!=$id) {
				exit('This class already exists! Please, choose other category or change class number.');
			}
			// Update the data
			$sql = 'UPDATE `appletree_personnel`.`classes` SET 
				`name` = :name,
				`id_teacher` = :id_teacher,
				`ed_lvl` = :ed_lvl,
				`std_num` = :std_num
				WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $id,
				':name' => $name,
				':id_teacher' => $id_teacher,
				':ed_lvl' => $_POST['ed_lvl'],
				':std_num' => $std_num]);
		}
		else // If the class does not exist
		{
			// Insert the data
			$sql = 'INSERT INTO `appletree_personnel`.`classes`(`id`,`name`,`id_teacher`,`ed_lvl`,`std_num`)
					VALUES (:id, :name, :id_teacher, :ed_lvl, :std_num)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $id,
				':name' => $name,
				':id_teacher' => $id_teacher,
				':ed_lvl' => $_POST['ed_lvl'],
				':std_num' => $std_num]);
			// Delete the previous record if it exists ('id' should not be an empty string otherwise)
			// and the class ID (name) has changed
			if ($_POST['id']!='' && $_POST['id']!= $id) {
				// Updating class id for students in the class
				$sql = 'UPDATE `appletree_personnel`.`students` SET `id_class`= :id_new WHERE `id_class` = :id_old';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([':id_old' => $_POST['id'], ':id_new' => $id]);
				// Delete the class
				$stmt = $pdo->prepare('DELETE FROM `appletree_personnel`.`classes` WHERE `id` = :id');
				$stmt->execute([':id' => $_POST['id']]);
			}
		}
		exit(0);
	} else { exit('Unknown action initiated!'); }
} catch (Exception $e) {
	exit($e->getMessage());
}

// The functions below are used to filtrate input strings via encoded fuctions
// and throw corresponting exceptions in case variable is undefined or empty string or does not match required regular expression.
function filtrateString($a_string){
	if (is_null($a_string) || !isset($a_string))
		throw new Exception('Some variables are undefined or null!', 1);
	else
		return htmlspecialchars(trim($a_string));
}
function is_valid($a_string, $reg_ex){
	if (!preg_match('/'.$reg_ex.'/',$a_string))
		throw new Exception('Invalid class id (number)!', 1);
	else
		return $a_string;
}
?>