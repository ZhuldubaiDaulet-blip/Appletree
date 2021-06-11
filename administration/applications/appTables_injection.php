<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
	require_once($connection_config);
	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}
	// Terminate if the required argument is not passed
	if (!isset($_POST['role'])) {
		exit('False');
	}
	// Variate sql queries depending on the role
	if ($_POST['role'] == 'teachers') {
		$sql1 = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "app_teachers" AND `table_schema` = "appletree_personnel" AND
		(`column_name` = "name" OR `column_name` = "surname" OR `column_name` = "sex" OR `column_name` = "email" OR `column_name` = "app_date") ORDER BY `ORDINAL_POSITION`';
		$sql2 = 'SELECT `id`, `name`, `surname`, `sex`, `email`, `app_date` FROM `appletree_personnel`.`app_teachers`';
	} elseif ($_POST['role'] == 'students') {
		$sql1 = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "app_students" AND `table_schema` = "appletree_personnel" AND
		(`column_name` = "name" OR `column_name` = "surname" OR `column_name` = "sex" OR `column_name` = "email" OR `column_name` = "app_date") ORDER BY `ORDINAL_POSITION`';
		$sql2 = 'SELECT `id`, `name`, `surname`, `sex`, `email`, `app_date` FROM `appletree_personnel`.`app_students`';
	}
	// Terminate if the argument has an incorrect value
	else { exit('False'); }
	// Field descriptions
	$stmt1 = $pdo->query($sql1);
	// The person's data
	$stmt2 = $pdo->query($sql2);
?>
	<table class="table table-bordered">
		<!-- Table head -->
		<thead class="thead-light">
			<tr>
		        <th scope="row" width="4%">#</th>
		        <?php
		        //------------------- Filling the column names with the descriptions of the fields
		        while ($descriptions_array = $stmt1->fetch(PDO::FETCH_COLUMN)) {
		        	echo '<th scope="row">'. $descriptions_array . '</th>';	
		        }
		    	?>
		    	<th scope="row" width="14%">#</th>
		    </tr>
		</thead>
		<!-- Table rows -->
		<tbody>
			<?php 	//------------------- Filling the table
			$i = 0;
			while($applicantData_array = $stmt2->fetch(PDO::FETCH_NUM)):
			$i++;
			?>
		
				<tr>
					<?php
						$id = $applicantData_array[0];
						echo '<td role="button" class="hover" onclick=\'insertCV("'.$id.'","'.$_POST['role'].'", "'.$appCvInject_url.'")\'>'.$i.'</td>';
						unset($applicantData_array[0]);
						foreach ($applicantData_array as $value) {
							echo '<td>'.$value.'</td>';
						}
					?>		
					<!-- Control buttons -->
					<td>
						<button class="btn btn-control" onclick="insertCV('<?=$id?>','<?=$_POST['role']?>', '<?=$appCvInject_url?>')"><img src="<?=$imgBrw?>" alt="Brw"></button>
						<button class="btn btn-control" onclick="appAdd('<?=$id?>', '<?=$_POST['role']?>')"><img src="<?=$imgAdd?>" alt="Add"></button>
						<button class="btn btn-control" onclick="appDel('<?=$id?>', '<?=$_POST['role']?>')"><img src="<?=$imgDel?>" alt="Del"></button>
					</td>
				</tr>
	
			<?php endwhile; ?>
		</tbody>
	</table>