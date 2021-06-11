<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}
	// Terminate if the required arguments are not passed
	if (!isset($_POST['id']) || !isset($_POST['role'])) {
		exit('False');
	}
?>
	<!-- Control buttons -->
	<div class="w-75 d-flex justify-content-between">
		<button class="btn btn-success w-50 mx-4" onclick="memUpd(<?=$_POST['id']?>, '<?=$_POST['role']?>')">Сохранить изменения</button>
		<button class="btn btn-warning w-50 mx-4" onclick="memDel(<?=$_POST['id']?>, '<?=$_POST['role']?>')">Удалить</button>
	</div>

	<form id="form" class="mt-3">
		<?php
			// Loading the corresponding editing table
			if ($_POST['role'] == 'students')
				include_once($memStdEdtTbInject_ldp);
			else
				include_once($memTchEdtTbInject_ldp);
		?>
	</form>
<script>
	// Pass data to update the record of the corresponding profile set.
	// Record id and profile type (teacher vs student) is passed as 'arg_id' and 'role'
	function memUpd(arg_id, role) {
		// Get an array of objects for every form field
		let fields = $('form#form').serializeArray();
		// The object that will contain all data
		let data = new Object();
		// Fill the object with the data
		fields.forEach(function(value){ data[value['name']] = value['value']; })
		// To pass the role as a part of data
		data['role'] = role;
		$.ajax({
			url: "<?= $cvUpdProcessing_url ?>",
			type: 'POST',
			cache: false,
			data: data,
			beforeSend: function() {
				$("#loader_div").removeClass("hidden");
			},
			success: function(reply){
				if (reply == 0)
				{
					// Return to updated members list
					insertList(role,'<?=$memTables_url?>');
				}
				else
				{
					alert(reply);
					return;
				}
			}
		})
		$("#loader_div").addClass("hidden");
		return;
	}
</script>