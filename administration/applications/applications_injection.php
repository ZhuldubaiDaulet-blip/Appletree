<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);

	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}

	// Storing all necessary files in arrays for further import
	$customScripts_array = array('insert.js');
	$customStylesheets_array = array('tables.style.css');
?>
	<head>
		<?php
		if (!empty($customStylesheets_array))
		    foreach ($customStylesheets_array as $value) { echo "<link rel='stylesheet' href=$css$value>".PHP_EOL; }
		if (!empty($customStyles_css)) { echo "<style> $customStyles_css </style>".PHP_EOL; }
		?>
	</head>
	<div class="container">
		<nav class="btn-group my-4 d-flex w-50">
			<button class="btn btn-secondary my-4 py-3" onclick="insertList('teachers','<?=$appTables_url?>')">Учителя</button>
			<button class="btn btn-secondary my-4 py-3" onclick="insertList('students','<?=$appTables_url?>')">Ученики</button>
		</nav>
		<!-- The div in which submodules are loaded -->
		<div id="content">
				<?php
					if($_POST['role'] == '')
						$_POST['role'] = 'teachers';
					include_once($appTables_ldp);
				?>
		</div>
	</div>
<script>
	// The function sends POST form to the other file to insert new record
	// with data from the record of the given ID and role
	function appAdd(arg_id, role){
		$.ajax({
			url: "<?=$recordProcessing_url?>",
			type: 'POST',
			cache: false,
			data: {
				'id':arg_id,
				'role':role,
				'action':'add'
			},
			beforeSend: function() {
				$("#loader_div").removeClass("hidden");
			},
			success: function(data){
				if (data == 0)
				{
					var result = confirm("The applicant has been successfully added to the database! Press 'OK' to remain on this page. Press 'Cancel' to shift to members list.")
					if (result)
						insertList(role, "<?=$appTables_url?>");
					else
						// Redirect to CV editing interface
						$("button[data-essence = 'members']").trigger("click", [role]);
					return;
				}
				else
				{
					alert(data);
					return;
				}
			}
		});
		return;
	}


	// The function sends POST form to the other file to delete the record of the given ID and role
	// from the corresponding applications table
	function appDel(arg_id, role) {
		var confirmation = confirm("Do you want to delete this application from the database?");
		if (confirmation)
		{
			$.ajax({
				url: "<?=$recordProcessing_url?>",
				type: 'POST',
				cache: false,
				data: {
					'id':arg_id,
					'role':role,
					'action':'delete'

				},
				beforeSend: function() {
					$("#loader_div").removeClass("hidden");
				},
				success: function(data){
					if (data == 0)
					{
						insertList(role, "<?=$appTables_url?>");
					}
					else
					{
						alert(data);
						return;
					}
				}
			});
		}
		return;
	}
</script>
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>