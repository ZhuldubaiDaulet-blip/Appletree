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

	// Fetch descriptions
	$sql = 'SELECT `column_comment`,`column_name` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "students" AND `table_schema` = "appletree_personnel" ORDER BY `ORDINAL_POSITION`';
	$stmt = $pdo->query($sql);
	$columnsData_array = $stmt->fetchAll();
	// Fetch particular record's data
	$stmt = $pdo->prepare('SELECT * FROM `appletree_personnel`.`students` WHERE `id` = :id');
	$stmt->execute([':id' => $_POST['id']]);
	$recordData_array = $stmt->fetch(PDO::FETCH_NUM);
	// Get and set the id of the current class
	$recordData_array[0] = ($recordData_array[0] == '')? 'null':$recordData_array[0];
?>
<table class="table table-bordered">
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[0]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[0]['column_name']?>">
				<option value="null">None</option>
				<?php
					// Fetch option values as Class shortcuts and teacher data (classes without a teacher will not be displayed)
					$stmt = $pdo->query("SELECT `classes`.`id`, `classes`.`std_num`,`teachers`.`name`, `teachers`.`surname` FROM `appletree_personnel`.`classes` INNER JOIN `appletree_personnel`.`teachers` ON `classes`.`id_teacher` = `teachers`.`id`");
					while ($select_options = $stmt->fetch()):
				?>
					<option value="<?=$select_options['id']?>"><?=$select_options['id'] .', '. $select_options['name'] .' '. $select_options['surname'] .' ('.$select_options['std_num'].' student[s])'?></option>
				<?php endwhile; ?>
			</select>
		</td>
	</tr>
	<tr>
    	<th scope='col' width="40%" ><?=$columnsData_array[1]['column_comment']?></th>
    	<td>
    		<input type="text" disabled="true" class="form-control" value="<?=$recordData_array[1]?>">
    		<input type="hidden" name="<?=$columnsData_array[1]['column_name']?>" required="true" value="<?=$recordData_array[1]?>">
    	</td>
    </tr>
	<?php
	$i = 2;
	while ( $i < 4):?>
		<tr>
			<th scope='col' width="40%" ><?=$columnsData_array[$i]['column_comment']?></th>
			<td>
				<input type="text" class="form-control" name="<?=$columnsData_array[$i]['column_name']?>" required="true" value="<?=$recordData_array[$i]?>">
			</td>
		</tr>
	<?php $i++; endwhile;?>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[4]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[4]['column_name']?>">
				<option value="Male">Male</option>
				<option value="Female">Female</option>
				<option value="Other">Other</option>
			</select>
		</td>
	</tr>
	<?php
	$i = 5;
	while ( $i < 8):?>
		<tr>
			<th scope='col' width="40%" ><?=$columnsData_array[$i]['column_comment']?></th>
			<td>
				<input type="text" class="form-control" name="<?=$columnsData_array[$i]['column_name']?>" required="true" value="<?=$recordData_array[$i]?>">
			</td>
		</tr>
	<?php $i++; endwhile;?>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[8]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[8]['column_name']?>">
				<option value="1">Группа</option>
				<option value="0">Частный</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[9]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[9]['column_name']?>">
				<option value="Undetermined">Неопределенный</option>
				<option value="Beginner">Начинающий</option>
				<option value="Elementary">Начальный</option>
				<option value="Pre-Intermediate">Предпороговый уровень</option>
				<option value="Intermediate">Пороговый уровень</option>
				<option value="Upper-intermediate">Продвинутый пороговый уровень</option>
				<option value="Advanced">Уровень профессионального владения</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[11]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[11]['column_name']?>" >
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[10]['column_comment']?></th>
		<td>
			<input type="text" disabled="true" class="form-control" value="<?=$recordData_array[10]?>">
			<input type="hidden" name="<?=$columnsData_array[10]['column_name']?>" required="true" value="<?=$recordData_array[10]?>">
		</td>
	</tr>
</table>
<script>
	// The scripts select actual values for '<select>' tags
	$(document).ready(function(){
		$('select[name=<?=$columnsData_array[0]['column_name']?>]').val("<?=$recordData_array[0]?>");
		$('select[name=<?=$columnsData_array[8]['column_name']?>]').val("<?=$recordData_array[8]?>");
		$('select[name=<?=$columnsData_array[9]['column_name']?>]').val("<?=$recordData_array[9]?>");
		$('select[name=<?=$columnsData_array[11]['column_name']?>]').val("<?=$recordData_array[11]?>");
	});
</script>