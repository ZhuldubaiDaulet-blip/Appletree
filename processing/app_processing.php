<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
// Redirect if the required argument is not passed
if (!isset($_POST['application_type'])) {
	header("Location:$adminIndex_url");
}

try {
	// Filtrate common for both application types input
	$_POST['name'] = is_valid(filtrateString( $_POST['name']),'^[A-Z]{1}[a-z]{0,19}$');
	$_POST['surname'] = is_valid(filtrateString( $_POST['surname']),'^[A-Z]{1}[a-z]{0,19}$');
	$_POST['sex'] = is_valid(filtrateString( $_POST['sex']),'^[A-Z]{1}[a-z]{3,6}$');
	$_POST['birth_year'] = is_valid(filtrateString( $_POST['birth_year']),'^([1][9][2-9]|[2][0-2][0-9])\d{1}$');
	$_POST['phone_number'] = filtrateString( $_POST['phone_number']);
	$_POST['email'] = is_valid(is_valid(filtrateString( $_POST['email']),
			'^[a-z0-9._%+-]+@[a-z.-]+\.[a-z]{2,}$'),'^.{5,50}$');
	$_POST['ed_lvl'] = is_valid(filtrateString( $_POST['ed_lvl']),'^[A-Z]{1}[a-z]{0,24}$');
	$_POST['app_date'] = date('Y-m-d');

	if ($_POST['application_type']=='teacher') // If application is a teacher form
	{
		// Specific input from teacher application form
		$_POST['exp'] = is_valid(filtrateString( $_POST['exp']),'^([0-9]|[1-9][0-9])$');
		$_POST['opt_radio1'] = is_valid(filtrateString( $_POST['opt_radio1']),'(^1$|^0$)');
		$_POST['opt_radio2'] = is_valid(filtrateString( $_POST['opt_radio2']),'(^1$|^0$)');
		$_POST['opt_radio3'] = is_valid(filtrateString( $_POST['opt_radio3']),'(^1$|^0$)');
		$_POST['summary'] = filtrateString( $_POST['summary']);
		// If the length of the summary is longer than 2500 characters
		if (mb_strlen($_POST['summary'])>2500)
			throw new Exception('Characters limit is exceeded! Please check tabulations / newlines and try again. Length is: '.mb_strlen($_POST['summary']), 1);

		// Check if any applicant or stuff member with same name and surname is recorded
		$sql_check1 = 'SELECT EXISTS( SELECT id FROM `appletree_personnel`.`app_teachers` WHERE (`name` = :name AND `surname` = :surname))';
		$stmt = $pdo->prepare($sql_check1);
		$stmt->execute([':name' => $_POST['name'], ':surname' => $_POST['surname']]);
		// Throw an exception if the inquery yields any result
		if ($stmt->fetchColumn())
			throw new Exception('A person with such name and surname already applied!', 1);
		// Check if any applicant or stuff member with same phone number or email is recorded
		$sql_check2 = 'SELECT EXISTS( SELECT id FROM `appletree_personnel`.`app_teachers` WHERE (`email` = :email OR `phone_number` = :phone_number))';
		$sql_check3 = 'SELECT EXISTS( SELECT id FROM `appletree_personnel`.`teachers` WHERE (`email` = :email OR `phone_number` = :phone_number))';
		$stmt1 = $pdo->prepare($sql_check2);
		$stmt1->execute([':email' => $_POST['email'], ':phone_number' => $_POST['phone_number']]);
		$stmt2 = $pdo->prepare($sql_check3);
		$stmt2->execute([':email' => $_POST['email'], ':phone_number' => $_POST['phone_number']]);
		// Throw an exception if the inqueries yield any result
		if ($stmt1->fetchColumn() || $stmt2->fetchColumn())
			throw new Exception('The given phone number or email is already occupied!', 1);

		// Insert the data
		$sql = 'INSERT INTO `appletree_personnel`.`app_teachers`
			(name, surname, app_date, birth_year, phone_number, email, ed_lvl, exp, sex, summary, opt_radio1, opt_radio2, opt_radio3)
			VALUES (:name, :surname, :app_date, :birth_year, :phone_number, :email, :ed_lvl, :exp, :sex, :summary, :opt_radio1, :opt_radio2, :opt_radio3)';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':name' => $_POST['name'],
			':surname' => $_POST['surname'],
			':app_date' => $_POST['app_date'],
			':birth_year' => $_POST['birth_year'],
			':phone_number' => $_POST['phone_number'],
			':email' => $_POST['email'],
			':ed_lvl' => $_POST['ed_lvl'],
			':exp' => $_POST['exp'],
			':sex' => $_POST['sex'],
			':summary' => $_POST['summary'],
			':opt_radio1' => $_POST['opt_radio1'],
			':opt_radio2' => $_POST['opt_radio2'],
			':opt_radio3' => $_POST['opt_radio3']]);
		exit(0);
	}
	elseif($_POST['application_type']=='student') // If the application is a student form
	{
		// Specific input from student application form
		$_POST['opt_checkbox1'] = is_valid(filtrateString( $_POST['opt_checkbox1']),'(^1$|^0$)');
		$_POST['opt_checkbox2'] = is_valid(filtrateString( $_POST['opt_checkbox2']),'(^1$|^0$)');
		$_POST['preferences'] = filtrateString( $_POST['preferences']);
		// Check if the string is longer than 700 characters
		if (mb_strlen($_POST['preferences'])>700)
			throw new Exception('Characters limit is exceeded! Please check tabulations / newlines and try again. Length is: '.mb_strlen($_POST['preferences']), 1);
		// Check if any applicant or student member with same name and surname is recorded
		$sql_check1 = 'SELECT EXISTS( SELECT id FROM `appletree_personnel`.`app_students` WHERE (name = :name AND surname = :surname))';
		$sql_check2 = 'SELECT EXISTS( SELECT id FROM `appletree_personnel`.`students` WHERE (name = :name AND surname = :surname))';
		$stmt1 = $pdo->prepare($sql_check1);
		$stmt1->execute([':name' => $_POST['name'], ':surname' => $_POST['surname']]);
		$stmt2 = $pdo->prepare($sql_check2);
		$stmt2->execute([':name' => $_POST['name'], ':surname' => $_POST['surname']]);
		// Throw an exception if the inqueries yield any result
		if ($stmt1->fetchColumn() || $stmt2->fetchColumn())
			throw new Exception('A person with such name and surname already applied/enrolled!', 1);

		// Insert the data
		$sql = 'INSERT INTO `appletree_personnel`.`app_students`
			(name, surname, sex, birth_year, phone_number, email, group_ls, ed_lvl, app_date, opt_checkbox1, opt_checkbox2, preferences)
			VALUES (:name, :surname, :sex, :birth_year, :phone_number, :email, :group_ls, :ed_lvl, :app_date, :opt_checkbox1, :opt_checkbox2, :preferences)';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':name' => $_POST['name'],
			':surname' => $_POST['surname'],
			':sex' => $_POST['sex'],
			':birth_year' => $_POST['birth_year'],
			':phone_number' => $_POST['phone_number'],
			':email' => $_POST['email'],
			':group_ls' => $_POST['group_ls'],
			':ed_lvl' => $_POST['ed_lvl'],
			':app_date' => $_POST['app_date'],
			':opt_checkbox1' => $_POST['opt_checkbox1'],
			':opt_checkbox2' => $_POST['opt_checkbox2'],
			':preferences' => $_POST['preferences']]);
		exit(0);
	}
	else // If the application is neither teacher not student form
		exit('False');
} catch (Exception $e) {
	exit($e->getMessage());
}

// The functions below are used to filtrate input strings via encoded fuctions
// and throw corresponting exceptions in case variable is undefined or empty string or does not match required regular expression (passed as an argument to the function).
function filtrateString($a_string){
	if (is_null($a_string) || !isset($a_string))
		throw new Exception('Some variables are undefined or null!', 1);
	else
		return htmlspecialchars(trim($a_string));
}
function is_valid($a_string, $reg_ex){
	if (!preg_match('/'.$reg_ex.'/',$a_string))
		throw new Exception('Please reload the page and fill the fields correctly.', 1);
	else
		return $a_string;
}	
?>