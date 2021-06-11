<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once ($connection_config);

	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login']) || !isset($_POST['url'])) {
		header("Location:$authorizationPage_url");
	}

	// Fixing url address to implement links correctly
	//(otherwise url would be for this file, not the one it is being loaded to)
	$url = $_POST['url'];

	// Storing all necessary files in arrays for further import
	$customStylesheets_array = array('navbar_schedule.style.css');
	$customScripts_array = array('smooth_scroll.js', 'scroll_schedule_page.js');
	//$customStyles_css = "";
	//$spinner_src = $imgs . "spinner.gif";
	$days_array = array('Monday','Tuesday','Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

	// Getting information about class teachers from the database
	$sql = 'SELECT `classes`.`id`, `teachers`.`name`, `teachers`.`surname`, `classes`.`std_num` FROM `appletree_personnel`.`classes` INNER JOIN `appletree_personnel`.`teachers` ON `classes`.`id_teacher` = `teachers`.`id`';
	$stmt= $pdo->query($sql);

	// Creating and filling an associative array (key = DB table's id column value, class code in other words)
	// to have a two-dimensional array and alleviate further processing
	$classesAssoc = array();
	while ($classes = $stmt->fetch()) {
		$classesAssoc[$classes['id']] = array('name' => $classes['name'], 'surname' => $classes['surname'], 'std_num' => $classes['std_num']);
	}

?>
	<div id="content">
		<head>
			<?php
			if (!empty($customStylesheets_array))
			    foreach ($customStylesheets_array as $value) { echo "<link rel='stylesheet' href=$css$value>".PHP_EOL; }
			if (!empty($customStyles_css)) { echo "<style> $customStyles_css </style>".PHP_EOL; }
			?>
		</head>
		<div id="overlay" class="overlay"></div>
		<div id="navbar" class="navbar w-100 shadow">
			<nav>
				<ul class="row" style="list-style-type: none;">
					<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-light border border-info" href="<?=$url?>#headerdiv">Up</a></li>
					<?php foreach ($days_array as $a_day): // Display a link-button for each day of week ?>
						<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-light" href="<?=$url?>#section-<?=strtolower($a_day)?>"><?=$a_day?></a></li>
					<?php endforeach ?>


				</ul>
			</nav>
		</div>
		<div class="container">
			<section id="section-navbar">
					<nav>
						<ul class="row px-0" style="list-style-type: none;">
							<?php foreach ($days_array as $a_day): // Display a link-button for each day of week ?>
								<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-light" href="<?=$url?>#section-<?=strtolower($a_day)?>"><?=$a_day?></a></li>
							<?php endforeach ?>
						</ul>
					</nav>
			</section>
			<hr>
				<div class="d-block px-3">
					<button class="btn btn-light w-100" onclick="schEdt()">Редактировать</button>
				</div>
			<hr>
			<?php foreach ($days_array as $weekDay): // Display the schedule for each day
				$tableName = strtolower($weekDay);

				// Taking the information about time sessions from the corresponding table in the database to fill schedule table on the webpage later
				$sql = "SELECT `session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`".$tableName."` WHERE `id` = 0";
				$stmt = $pdo->query($sql);
				// One day's (webpage) table's first row's records (id = 0)
				$sessionColumn = $stmt->fetch(PDO::FETCH_NUM);

				$sql = "SELECT `room`,`session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`".$tableName."` WHERE NOT `id` = 0";
				$stmt = $pdo->query($sql);
				// The day's (webpage) table's other row's records (with class code) as an array of arrays
				$sessionRows = $stmt->fetchAll(PDO::FETCH_ASSOC);


				?>
				<section id='section-<?=$tableName?>'>
				<p class='display-4 mb-4 pb-4'>
					<?=$weekDay?>
					<button class='edit-button btn mx-3' onclick="schEdt('<?=$weekDay?>')"><small>Edit</small></button>
				</p>
				<div style="overflow-x: auto;">
					<table class="table table-bordered schedule-table">
						<!-- Table head -->
						<thead class="thead-light">
							<tr>
								<th scope="col" width="12%">Занятие\Кабинет</th>
								<?php
								// Filling the table head row with classroom names
								foreach ($sessionRows as $val):
									echo "<th scope='col'>Room ". $val['room']. "</th>";
								endforeach;?>
						    </tr>
						</thead>
						<!-- Table rows -->
						<tbody>
						<?php
						// Filling the first cell of every row with session time
						foreach ($sessionColumn as $key=>$value): ?>
							<tr class="tr tr-<?=$key?>">
								<th scope="col"><?=$value?></th>
								<?php
								// Filling the next cells of the current row with class codes
								foreach ($sessionRows as $val):
									// The variable used to access the field (in DB) corresponding to the row of the webpage table
									$session = "session". ($key+1);

									if (isset($val[$session])) {
										if (isset($classesAssoc[$val[$session]])) {
											$val[$session]= $val[$session] . ', ' . $classesAssoc[$val[$session]]['name'] . ' ' . $classesAssoc[$val[$session]]['surname'] . ', ' . $classesAssoc[$val[$session]]['std_num'] . ' student(s)';
										}
										echo "<td style='min-width: 12em;'>$val[$session]</td>";
									}
									else
									{
										echo '<td><i>EMPTY</i></td>';
									}
								endforeach;?>
						    </tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
			<?php endforeach;?>
		</div>
	</div>

<!-- Importing custom scripts -->
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>
<script>
	// The function loads schedule editing interface depending on the input argument
	function schEdt(day = 'Monday'){
		$("#loader_div").removeClass("hidden");
		$("#content").empty();
		$("#content").load('<?=$schEditInject_url?>', { day: day, url:'<?=$url?>'}, function( responseText, textStatus, jqXHR ){
			// Displaying the error in console
			if (textStatus == "error") {
				let message = "'clsBrowse' function error occured: ";
				console.error( message + jqXHR.status + " " + jqXHR.statusText );
			} else{
				$("#loader_div").addClass("hidden");
			}
		});
		return;
	}
</script>