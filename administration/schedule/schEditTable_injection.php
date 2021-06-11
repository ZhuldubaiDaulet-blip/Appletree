<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}
	// Terminate if the required argument is not passed
	if (!isset($_POST['day'])) {
		exit('False');
	}

	$customStyles_css = '.table-button{ transition: 0.15s ease-in-out;} .table-button:focus{ outline: 0; box-shadow: inset 0 0 0 .2rem rgba(38,143,255,.5);} ';
	// Set the table name
	$tableName = strtolower($_POST['day']);
	try {
		// Taking the information about time sessions from the corresponding table in the database to fill schedule table on the webpage later
		$sql = 'SELECT `session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`'.$tableName.'` WHERE `id` = 0';
		$stmt = $pdo->query($sql);
		// One day's (webpage) table's first row's records (id = 0)
		$sessionColumn = $stmt->fetch(PDO::FETCH_NUM);

		// The day's (webpage) table's other row's records (with class code) as an array of arrays
		$sql = 'SELECT `room`,`session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`'.$tableName.'` WHERE NOT `id` = 0';
		$stmt = $pdo->query($sql);
		$records_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Getting information about class teachers from the database
		$sql = 'SELECT `classes`.`id`, `teachers`.`name`, `teachers`.`surname`, `classes`.`std_num` FROM `appletree_personnel`.`classes` INNER JOIN `appletree_personnel`.`teachers` ON `classes`.`id_teacher` = `teachers`.`id`';
		$stmt= $pdo->query($sql);
		// Creating and filling an associative array (key = DB table's id column value, class code in other words)
		// to have a two-dimensional array and alleviate further processing
		$classesAssoc = array();
		while ($classes = $stmt->fetch()) {
			$classesAssoc[$classes['id']] = array('name' => $classes['name'], 'surname' => $classes['surname'], 'std_num' => $classes['std_num']);
		}
	} catch (Exception $e) {
		exit ('Error occured during execution! '.$e->getMessage());
	}
	?>

	<h1 class='font-weight-light mx-2 pt-4'><?=$_POST['day']?></h1>
	<form id='form-classes' data-day="<?=$tableName?>" data-col-number="<?=count($records_array)-1?>" style="overflow-x: auto;">
		<table class="table table-bordered schedule-table">
			<!-- Table head -->
			<thead class="thead-light">
				<tr>
					<th scope="col">Занятие\Кабинет</td>
					<?php // Filling the first row with auditory numbers
					foreach ($records_array as $recordData):
						echo '<th scope="col">Room '. $recordData['room']. '</th>';
					endforeach;?>
			    </tr>
			</thead>
			<!-- Table rows -->
			<tbody>
			<?php
			// Filling first record of each row with lesson time
			foreach ($sessionColumn as $key=>$lessonTime): ?>
				<tr class="tr tr-<?=$key?>">
					<th scope="col"><?=$lessonTime?></th>

					<?php // Filling the next records of the current rows with class codes
					foreach ($records_array as $columnNumber => $recordData):
						// The variable used to access the field (in DB) corresponding to the row of the webpage table
						$sessionNumber = 'session'. ($key+1);
						// Set <td> text value if available from the database
						if (isset($recordData[$sessionNumber])){
							$fullData = $recordData[$sessionNumber];
							// Append information about class teacher if a class with the given id was found in the classes table
							if (isset($classesAssoc[$recordData[$sessionNumber]])) {
								$fullData .= ', ' . $classesAssoc[$recordData[$sessionNumber]]['name'] . ' ' . $classesAssoc[$recordData[$sessionNumber]]['surname'] . ', ' . $classesAssoc[$recordData[$sessionNumber]]['std_num'] . ' student(s)';
							}
						} else
							$fullData = '<i class="text-muted">Empty</i>';
							?>
							<td role="button" tabindex="0" class="table-button">
								<span><?= $fullData ?></span>
								<input type="hidden" class="column-<?=$columnNumber?>" name="<?=$sessionNumber?>" value="<?=$recordData[$sessionNumber]?>">
							</td>
					<?php endforeach;?>

			    </tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</form>