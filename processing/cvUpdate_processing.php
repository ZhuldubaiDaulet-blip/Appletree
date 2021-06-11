<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
// Terminate if the required argument is not passed
if (!isset($_POST['role'])) {
	exit('False');
}

// Set the applicants table name
if ($_POST['role']=='teachers')
	$tableName = '`appletree_personnel`.`teachers`';
elseif ($_POST['role']=='students')
	$tableName = '`appletree_personnel`.`students`';
else
	exit('False');

try {
	// Check if the record still exists (or simply a record with the id)
	$sql_check1 = 'SELECT EXISTS( SELECT `id` FROM '.$tableName.' WHERE `id` = :id)';
	$stmt = $pdo->prepare($sql_check1);
	$stmt->execute([':id' => $_POST['id']]);
	// Throw an exception if query does not yield any result
	if (!$stmt->fetchColumn())
		throw new Exception('A record with such ID does not exist!', 1);
	// Filtrate common to both roles input
	$_POST['name'] = is_valid(filtrateString( $_POST['name']),'^[A-Z]{1}[a-z]{0,19}$');
	$_POST['surname'] = is_valid(filtrateString( $_POST['surname']),'^[A-Z]{1}[a-z]{0,19}$');
	$_POST['sex'] = is_valid(filtrateString( $_POST['sex']),'^[A-Z]{1}[a-z]{3,6}$');
	$_POST['birth_year'] = is_valid(filtrateString( $_POST['birth_year']),'^([1][9][2-9]|[2][0,1][0-9])\d{1}$');
	$_POST['phone_number'] = is_valid(filtrateString( $_POST['phone_number']), '^[+]7 [(]\d{3}[)] \d{3}-\d{2}-\d{2}$');
	$_POST['email'] = is_valid(is_valid(filtrateString( $_POST['email']),
			'^[a-z0-9._%+-]+@[a-z.-]+\.[a-z]{2,}$'),'^.{5,50}$');
	$_POST['ed_lvl'] = is_valid(filtrateString( $_POST['ed_lvl']),'^[A-Z]{1}[A-Za-z-]{0,24}$');
	$_POST['set_date'] = validateDate(filtrateString($_POST['set_date']));

	if ($_POST['role']=='teachers') // For teachers
	{
		// Specific input for a teacher record
		$_POST['exp'] = is_valid(filtrateString( $_POST['exp']),'^([0-9]|[1-9][0-9])$');
		$_POST['opt_radio1'] = is_valid(filtrateString( $_POST['opt_radio1']),'(^1$|^0$)');
		$_POST['opt_radio2'] = is_valid(filtrateString( $_POST['opt_radio2']),'(^1$|^0$)');
		$_POST['opt_radio3'] = is_valid(filtrateString( $_POST['opt_radio3']),'(^1$|^0$)');
		
		// Update the data
		$sql = 'UPDATE '.$tableName.' SET 
			`name` = :name,
			`surname` = :surname,
			`sex` = :sex,
			`birth_year` = :birth_year,
			`phone_number` = :phone_number,
			`email` = :email,
			`ed_lvl` = :ed_lvl,
			`exp` = :exp,
			`set_date` = :set_date,
			`opt_radio1` = :opt_radio1,
			`opt_radio2` = :opt_radio2,
			`opt_radio3` = :opt_radio3
			WHERE `id` = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':id' => $_POST['id'],
			':name' => $_POST['name'],
			':surname' => $_POST['surname'],
			':sex' => $_POST['sex'],
			':birth_year' => $_POST['birth_year'],
			':phone_number' => $_POST['phone_number'],
			':email' => $_POST['email'],
			':ed_lvl' => $_POST['ed_lvl'],
			':exp' => $_POST['exp'],
			':set_date' => $_POST['set_date'],
			':opt_radio1' => $_POST['opt_radio1'],
			':opt_radio2' => $_POST['opt_radio2'],
			':opt_radio3' => $_POST['opt_radio3']]);
		exit(0);
	}
	else // For students
	{
		// Specific input for a student record
		$_POST['opt_checkbox1'] = is_valid(filtrateString( $_POST['opt_checkbox1']),'(^1$|^0$)');
		if ($_POST['id_class']=='null')
			$_POST['id_class'] = null;
		else {
			// Set language education level as of the class's
			$sql = 'SELECT `ed_lvl` FROM `appletree_personnel`.`classes` WHERE `id` = :id_class';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id_class' => $_POST['id_class']]);
			$_POST['ed_lvl'] = $stmt->fetch(PDO::FETCH_COLUMN);
			// Increment students number value by 1 in the new class
			$sql = 'UPDATE `appletree_personnel`.`classes` SET `std_num` = `std_num` + 1 WHERE `id` = :id_class';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id_class' => $_POST['id_class']]);
		}

		// Decrement students number vlaue by 1 in the previous class
		$sql = 'SELECT `id_class` FROM `appletree_personnel`.`students` WHERE `id` = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':id' => $_POST['id']]);
		if (!empty($id_class = $stmt->fetch(PDO::FETCH_COLUMN))) {
			$sql = 'UPDATE `appletree_personnel`.`classes` SET `std_num` = `std_num` - 1 WHERE `id` = :id_class';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id_class' => $id_class]);
		}

		// Update the data
		$sql = 'UPDATE '.$tableName.' SET
			`id_class` = :id_class,
			`name` = :name,
			`surname` = :surname,
			`sex` = :sex,
			`birth_year` = :birth_year,
			`phone_number` = :phone_number,
			`email` = :email,
			`group_ls` = :group_ls,
			`ed_lvl` = :ed_lvl,
			`set_date` = :set_date,
			`opt_checkbox1` = :opt_checkbox1
			WHERE `id` = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':id' => $_POST['id'],
			':id_class' => $_POST['id_class'],
			':name' => $_POST['name'],
			':surname' => $_POST['surname'],
			':sex' => $_POST['sex'],
			':birth_year' => $_POST['birth_year'],
			':phone_number' => $_POST['phone_number'],
			':email' => $_POST['email'],
			':group_ls' => $_POST['group_ls'],
			':ed_lvl' => $_POST['ed_lvl'],
			':set_date' => $_POST['set_date'],
			':opt_checkbox1' => $_POST['opt_checkbox1']]);
		exit(0);
	}
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
		throw new Exception('Please fill the fields correctly. Incorrect value - "'.$a_string.'"', 1);
	else
		return $a_string;
}
function validateDate($date, $format = 'Y-m-d')
{
    $temp = DateTime::createFromFormat($format, $date);
    if (!$temp || $temp->format($format) !== $date)
    	throw new Exception('Wrong data format', 1);
    else
    	return $date;
}
?>