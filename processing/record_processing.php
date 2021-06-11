<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
session_start();
// Block access for unathorized users
if (!isset($_SESSION['user_login'])) {
	header("Location:$authorizationPage_url");
}
// Terminate if required arguments are not passed
if (!isset($_POST['id']) || !isset($_POST['role']) || !isset($_POST['action'])) {
	exit('False');
}

// Set the applicants table name
if ($_POST['role'] == 'teachers')
	$appTable = 'appletree_personnel.app_teachers';
elseif ($_POST['role'] == 'students')
	$appTable = 'appletree_personnel.app_students';
else
	exit('False');

try{
	// Insert new record to a corresponding table
	if ($_POST['action'] == 'add') {
		// Fetch necessary applicant data
		$stmt = $pdo->prepare('SELECT * FROM '.$appTable.' WHERE `id` = :id');
		$stmt->execute([':id' => $_POST['id']]);
		$data_array = $stmt->fetch();
		$data_array['set_date'] = date('Y-m-d');
		$data_array['id_class'] = (isset($_POST['id_class']))? $_POST['id_class'] : null;
	
		// Insert the data
		if ($_POST['role'] == 'teachers'){ // For teachers
			$sql = 'INSERT INTO `appletree_personnel`.`teachers`
				(name, surname, sex, birth_year, phone_number, email, exp, ed_lvl, set_date, opt_radio1, opt_radio2, opt_radio3)
				VALUES (:name, :surname, :sex, :birth_year, :phone_number, :email, :exp, :ed_lvl, :set_date, :opt_radio1, :opt_radio2, :opt_radio3)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':name' => $data_array['name'],
				':surname' => $data_array['surname'],
				':sex' => $data_array['sex'],
				':birth_year' => $data_array['birth_year'],
				':phone_number' => $data_array['phone_number'],
				':email' => $data_array['email'],
				':exp' => $data_array['exp'],
				':ed_lvl' => $data_array['ed_lvl'],
				':set_date' => $data_array['set_date'],
				':opt_radio1' => $data_array['opt_radio1'],
				':opt_radio2' => $data_array['opt_radio2'],
				':opt_radio3' => $data_array['opt_radio3']]);
		}
		if ($_POST['role'] == 'students'){ // For students
			$sql = 'INSERT INTO `appletree_personnel`.`students`
				(id_class, name, surname, sex, birth_year, phone_number, email, group_ls, ed_lvl, set_date, opt_checkbox1)
				VALUES (:id_class, :name, :surname, :sex, :birth_year, :phone_number, :email, :group_ls, :ed_lvl, :set_date, :opt_checkbox1)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id_class' => $data_array['id_class'],
				':name' => $data_array['name'],
				':surname' => $data_array['surname'],
				':sex' => $data_array['sex'],
				':birth_year' => $data_array['birth_year'],
				':phone_number' => $data_array['phone_number'],
				':email' => $data_array['email'],
				':group_ls' => $data_array['group_ls'],
				':ed_lvl' => $data_array['ed_lvl'],
				':set_date' => $data_array['set_date'],
				':opt_checkbox1' => $data_array['opt_checkbox1']]);
		}
	}

	// Delete application if action was not 'add' and after CV was relocated
	$sql = 'DELETE FROM '.$appTable.' WHERE id = :id';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':id' => $_POST['id']]);
	exit(0);
} catch(Exception $e) { exit ($e->getMessage()); }
// Normally the system should not reach this
exit('Unknown action initiated!');
?>