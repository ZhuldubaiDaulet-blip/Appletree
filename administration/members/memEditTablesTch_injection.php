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
	$sql = 'SELECT `column_comment`,`column_name` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "teachers" AND `table_schema` = "appletree_personnel" ORDER BY `ORDINAL_POSITION`';
	$stmt = $pdo->query($sql);
	$columnsData_array = $stmt->fetchAll();
	// Fetch particular record's data
	$stmt = $pdo->prepare('SELECT * FROM `appletree_personnel`.`teachers` WHERE `id` = :id');
	$stmt->execute([':id' => $_POST['id']]);
	$recordData_array = $stmt->fetch(PDO::FETCH_NUM);
?>
<table class="table table-bordered">
	<tr>
    	<th scope='col' width="40%" ><?=$columnsData_array[0]['column_comment']?></th>
    	<td>
    		<input type="text" disabled="true" class="form-control" value="<?=$recordData_array[0]?>">
    		<input type="hidden" name="<?=$columnsData_array[0]['column_name']?>" required="true" value="<?=$recordData_array[0]?>">
    	</td>
    </tr>
	<?php
	$i = 1;
	while ( $i < 3):?>
		<tr>
			<th scope='col' width="40%" ><?=$columnsData_array[$i]['column_comment']?></th>
			<td>
				<input type="text" class="form-control" name="<?=$columnsData_array[$i]['column_name']?>" required="true" value="<?=$recordData_array[$i]?>">
			</td>
		</tr>
	<?php $i++; endwhile;?>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[3]['column_comment']?></th>
		<td>
			<select class="form-control" name="<?=$columnsData_array[3]['column_name']?>">
				<option value="Male">Mужской</option>
				<option value="Female">Женский</option>
				<option value="Other">Другой</option>
			</select>
		</td>
	</tr>
	<?php
	$i = 4;
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
				<option value="Any">Любой</option>
				<option value="Beginner">Начинающий</option>
				<option value="Elementary">Начальный</option>
				<option value="Pre-Intermediate">Предпороговый уровень</option>
				<option value="Upper-intermediate">Продвинутый пороговый уровень</option>
				<option value="Intermediate">Пороговый уровень</option>
				<option value="Advanced">Уровень профессионального владения</option>
			</select>
		</td>
	</tr>
	<?php
	$i = 10;
	while ( $i < 13):?>
		<tr>
			<th scope='col' width="40%" ><?=$columnsData_array[$i]['column_comment']?></th>
			<td>
				<select class="form-control" name="<?=$columnsData_array[$i]['column_name']?>" >
					<option value="1">Да</option>
					<option value="0">Нет</option>
				</select>
			</td>
		</tr>
	<?php $i++; endwhile;?>
	<tr>
		<th scope='col' width="40%" ><?=$columnsData_array[9]['column_comment']?></th>
		<td>
			<input type="text" disabled="true" class="form-control" value="<?=$recordData_array[9]?>">
			<input type="hidden" name="<?=$columnsData_array[9]['column_name']?>" required="true" value="<?=$recordData_array[9]?>">
		</td>
	</tr>
</table>
<script>
	// The script selects actual values for '<select>' tags
	$(document).ready(function(){
		$('select[name=<?=$columnsData_array[3]['column_name']?>]').val("<?=$recordData_array[3]?>");
		$('select[name=<?=$columnsData_array[8]['column_name']?>]').val("<?=$recordData_array[8]?>");
		<?php
		for($i= 10; $i<13; $i++)
			echo '$(\'select[name='.$columnsData_array[$i]['column_name'].']\').val("'.$recordData_array[$i].'");';
		?>

	});
</script>