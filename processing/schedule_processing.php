<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once($connection_config);
// Terminate if required arguments are not passed
if (!isset($_POST['tableName']) || !isset($_POST['tableData'])) {
	exit('False');
}

try {
	// Validate table name
	$days_array = array('monday','tuesday','wednesday', 'thursday', 'friday', 'saturday', 'sunday');
	// Check if the passed table name does not correspond to actual possible table name
	if (!in_array($_POST['tableName'], $days_array))
		throw new Exception('Wrong table name!', 1);
	
	// Execute the cycle for each row of the table
	foreach ($_POST['tableData'] as $rowKey => $rowData) {
		// Validate class id value to insert into the table
		foreach ($rowData as $fieldName => $value) {
			if ($value == '') {
				$rowData[$fieldName] = null;
			} else {
				$rowData[$fieldName] = is_valid($value,'^([GP]R|SP)[MBEPIUA]-[0-9]{1,9}$');
			}
		}
		// Update the data
		$sql = 'UPDATE `appletree_schedule`.`'.$_POST['tableName'].'` SET 
			`session1` = :session1,
			`session2` = :session2,
			`session3` = :session3,
			`session4` = :session4,
			`session5` = :session5,
			`session6` = :session6
			WHERE `id` = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			':session1' => $rowData['session1'],
			':session2' => $rowData['session2'],
			':session3' => $rowData['session3'],
			':session4' => $rowData['session4'],
			':session5' => $rowData['session5'],
			':session6' => $rowData['session6'],
			// Increment id value by one in order not to compensate the first unused record (which contains sessions data)
			':id' => $rowKey+1]);
	}
	exit(0);
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
		throw new Exception('Please reload the page and fill the fields correctly. Incorrect value - '. $a_string, 1);
	else
		return $a_string;
}	
?>