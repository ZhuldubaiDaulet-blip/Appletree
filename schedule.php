<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once ($connection_config);






	// Storing all necessary files in arrays for further import
	$customStylesheets_array = array('navbar_schedule.style.css', 'header.style.css', 'footer.style.css','loader.style.css', 'tables.style.css' );
	$customScripts_array = array('smooth_scroll.js', 'scroll_schedule_page.js', 'loader.js');
	$customStyles_css =  'body{ background: url(images/6.jpg) no-repeat center center fixed;
        background-size: cover; background opacity 0.2} ';
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
	<?php require_once($head_ldp); ?>
	<body >
	<!-- Importing the header -->
	<?php require_once($header_ldp); ?>
	<!-- The loader -->
	<div id="loader_div" class="loader">
		<img src="<?=$spinner_src?>" alt="spinner">
	</div	>



		<div id="navbar" class="navbar w-100 shadow bg-dark">
			<nav>
				<ul class="row" style="list-style-type: none;">
					<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-primary border border-info" href="<?=$url?>#headerdiv">Up</a></li>
					<?php foreach ($days_array as $a_day): // Display a link-button for each day of week ?>
						<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-primary" href="<?=$url?>#section-<?=strtolower($a_day)?>"><?=$a_day?></a></li>
					<?php endforeach ?>


				</ul>
			</nav>
		</div>
		<div class="container mt-4">
			<section id="section-navbar">
					<nav>
						<ul class="row px-0" style="list-style-type: none;">
							<?php foreach ($days_array as $a_day): // Display a link-button for each day of week ?>
								<li class="col-4 col-sm mb-3 mb-xl-0"><a class="text-truncate w-100 btn btn-success" href="<?=$url?>#section-<?=strtolower($a_day)?>"><?=$a_day?></a></li>
							<?php endforeach ?>
						</ul>
					</nav>
			</section>
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
				<p class='display-4 mb-4 pb-4 text-primary'>
					<?=$weekDay?>

				</p>
				<div style="overflow-x: auto; background-color:black">
					<table class="table table-bordered schedule-table text-white">
						<!-- Table head -->
						<thead class="thead-dark">
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
							<tr class="tr tr-<?=$key?> ">
								<th  scope="col"><?=$value?></th>
								<?php
								// Filling the next cells of the current row with class codes
								foreach ($sessionRows as $val):
									// The variable used to access the field (in DB) corresponding to the row of the webpage table
									$session = "session". ($key+1);

									if (isset($val[$session])) {
										if (isset($classesAssoc[$val[$session]])) {
											$val[$session]= $val[$session] . ', ' . $classesAssoc[$val[$session]]['name'] . ' ' . $classesAssoc[$val[$session]]['surname'] . ', ' . $classesAssoc[$val[$session]]['std_num'] . ' student(s)';
										}
										echo "<td style='min-width: 12em; background-color:black;'>$val[$session]</td>";
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
	</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Importing custom scripts -->
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>

<script>
$(document).ready(function(){

		// Deactivating loader
		fix_loader("loader_div");
	})


</script>