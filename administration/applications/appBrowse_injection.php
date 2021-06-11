<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
	require_once($connection_config);
	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}
	// Terminate if required argument is not passed
	if (!isset($_POST['id']) || !isset($_POST['role'])) {
		exit('False');
	}

	// Prepare data for fetching according to the role
	if ($_POST['role'] == 'teachers') {
		$sql1 = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "app_teachers" AND `table_schema` = "appletree_personnel" ORDER BY `ORDINAL_POSITION`';
		$stmt2 = $pdo->prepare('SELECT * FROM `appletree_personnel`.`app_teachers` WHERE `id` = :id');
	}
	elseif ($_POST['role'] == 'students') {
		$sql1 = 'SELECT `column_comment` FROM `information_schema`.`COLUMNS` WHERE `table_name` = "app_students" AND `table_schema` = "appletree_personnel" ORDER BY `ORDINAL_POSITION`';
		$stmt2 = $pdo->prepare('SELECT * FROM `appletree_personnel`.`app_students` WHERE `id` = :id');
	}
	// Terminate if the argument has an incorrect value
	else { exit('False'); }

	// Fetch column descriptions into an array
	$stmt1 = $pdo->query($sql1);
	$descriptions_array = $stmt1->fetchAll(PDO::FETCH_COLUMN);
	// Fetch particular record's data
	$stmt2->execute([':id' => $_POST['id']]);
	$data_array = $stmt2->fetch(PDO::FETCH_BOTH);
?>
	<hr>
	<h1 class="my-3"><?=$data_array['name'].' '.$data_array['surname'].' ('.$data_array['id'].')'?></h1>
	<div class="mt-3">
		<table class="table table-bordered" style="table-layout:fixed;">
			<!-- Table rows -->
			<?php foreach ($descriptions_array as $key => $value ):?>
			    <tr>
			    	<th scope='col' width="40%" ><?=$value?></th>
			    	<td style="word-wrap: break-word;" data-key='<?=$key?>'><?=$data_array[$key]?>
			    	</td>
			    </tr>
			<?php endforeach;?>
		</table>
	</div>
	<!-- Control buttons -->
	<div class="w-50 mt-3 d-flex">
		<button class="btn btn-success w-50 rounded-pill py-2 mx-2" onclick="appAdd(<?=$_POST['id']?>, '<?=$_POST['role']?>')">Accept</button>
		<button class="btn btn-warning w-50 rounded-pill py-2 mx-2" onclick="appDel(<?=$_POST['id']?>, '<?=$_POST['role']?>')">Reject</button>
	</div>
<script>
	$(document).ready(function(){
		<?php // Converting '0' and '1' to 'No' and 'Yes' in boolean fields.
		// The fields' id depends on the application type
		if ($_POST['role'] == 'teachers'): ?>
			const keys_array = [10,11,12];
		<?php elseif ($_POST['role'] == 'students'): ?>
			const keys_array = [7,10,11];
		<?php endif; ?>
		for(let el of keys_array)
			$('td[data-key="'+el+'"]').html(($('td[data-key="'+el+'"]').html() == 1 )? 'Yes' : 'No');
	});
</script>