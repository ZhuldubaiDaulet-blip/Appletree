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

	// Fetching descriptions
	$sql = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "classes" AND `table_schema` = "appletree_personnel" ORDER BY `ORDINAL_POSITION`';
	$stmt = $pdo->query($sql);
	$descriptions_array = $stmt->fetchAll(PDO::FETCH_COLUMN);
	// Fetching particular record's data
	$stmt = $pdo->prepare('SELECT * FROM `appletree_personnel`.`classes` WHERE `id` = :id');
	$stmt->execute([':id' => $_POST['id']]);
	$classData_array = $stmt->fetch(PDO::FETCH_BOTH);
	// Substituting teacher id with full name, id
	// and setting the title as class id and its teacher's full name if there is one
	$stmt = $pdo->prepare('SELECT `name`, `surname` FROM `appletree_personnel`.`teachers` WHERE `id` = :id');
	$stmt->execute([':id' => $classData_array['id_teacher']]);
	$title = $classData_array['id'];
	if($data = $stmt->fetch()){
		$classData_array['id_teacher'] = $data['name'] . ' ' . $data['surname'];
		$classData_array[3] = $data['name'] . ' ' . $data['surname'] . ' (ID: ' . $classData_array[3] . ')';
		$title.=', ' . $classData_array['id_teacher'];
	} else {
		$classData_array[3] = '<i class="text-muted">None</i>';
	}
?>
	<h1 class="mb-3 mt-5"><?= $title ?></h1>
	<!-- Control buttons -->
	<div class="w-75 d-flex justify-content-between">
		<button class="btn btn-success w-50 mx-4" onclick="clsBrw('<?=$clsEditInject_url?>', '<?=$_POST['id']?>')">Редактировать</button>
		<button class="btn btn-warning w-50 mx-4" onclick="clsDel('<?=$id?>')">Удалить</button>
	</div>
	<div class="my-3">
		<table class="table table-bordered">
			<?php foreach ($descriptions_array as $key => $value):?>

			    <tr>
			    	<th scope='col' width="40%" ><?=$value?></th>
			    	<td><?=$classData_array[$key]?>
			    	</td>
			    </tr>

			<?php endforeach;?>
		</table>

		<?php // Data for 'List of Students' of the class
		// Field descriptions
		$sql1 = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "students" AND `table_schema` = "appletree_personnel" AND
		(`column_name` = "name" OR `column_name` = "surname" OR `column_name` = "sex" OR `column_name` = "email" OR `column_name` = "birth_year") ORDER BY `ORDINAL_POSITION`';
		$stmt1 = $pdo->query($sql1);
		// Students' data
		$sql2 = 'SELECT `name`, `surname`, `sex`, `birth_year`, `email` FROM `appletree_personnel`.`students` WHERE `id_class` = :id';
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute([':id' => $_POST['id']]);
		?>

		<h2 class="mb-3 mt-5">List of Students</h2>
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
			        <th scope="col">#</th>
			        <?php
			        //------------------- Filling the column names with the descriptions of the fields
			        while ($descriptions_array = $stmt1->fetch(PDO::FETCH_COLUMN)) {
			        	echo '<th scope="col">'. $descriptions_array . '</th>';
			        }
			    	?>
			    </tr>
			</thead>
			<!-- Table rows -->
			<tbody>
				<?php 	//------------------- Filling the table
				$i = 0;
				while($studentData_array = $stmt2->fetch(PDO::FETCH_NUM)):
				$i++;
				?>

					<tr>
						<?php
							echo '<td>'.$i.'</td>';
							foreach ($studentData_array as $value) {
								if (!is_null($value))
									echo '<td>'.$value.'</td>';
								else
									echo '<td><i class="text-muted">None</i></td>';
							}
						?>
					</tr>

				<?php endwhile;
				// If the loop exited immediately
				if ($i == 0)
					echo "<tr><td class='text-muted'>No students</td></tr>".PHP_EOL;
				?>
			</tbody>
		</table>
	</div>