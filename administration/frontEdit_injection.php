<?php
	require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once ($connection_config);

	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login']) || !isset($_POST['url'])) {
		header("Location:$authorizationPage_url");
	}

	// Custom css for the page
	$customStyles_css = 'tr.borderless td { padding:0.1rem; align-self:center; } tr.borderless td input, textarea { border-color: transparent!important; padding: .75rem!important;}'
?>

<head>
	<?php
	if (!empty($customStylesheets_array))
	    foreach ($customStylesheets_array as $value) { echo "<link rel='stylesheet' href=$css$value>".PHP_EOL; }
	if (!empty($customStyles_css)) { echo "<style> $customStyles_css </style>".PHP_EOL; }
	?>
</head>
<div class="container">
	<nav class="my-4 w-50">
		<button class="btn btn-success w-50 py-3 my-4" onclick="txtUpd('<?=$txtUpdProcessing_url?>')">Сохранить изменения</button>
	</nav>
	<hr>

	<label class="mt-3 mb-2 pl-3" for="form-1"><h2 class="font-weight-light">Таблица общей информации</h2></label>
	<table id="form-1" class="table table-bordered">
		<tbody>
				<?php // Fetch short texts
				$stmt = $pdo->query("SELECT `id`,`description`,`text` FROM `appletree_general`.`short_texts`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="short_texts">
						<th scope='col' width="40%" ><?=$record['description']?></th>
						<td>
							<textarea rows="1" maxlength="400" type="text" name="text" data-table="short_texts" class="form-control"><?=$record['text']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>

				<tr class="bg-light"><th colspan="2"></th></tr>

				<?php // Fetch social media data
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`social_media`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="social_media">
						<th scope='col'><?=$record['description']?></th>
						<td>
							<textarea rows="1" maxlength="255" type="text" name="href" data-table="social_media" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['href']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>

				<tr class="bg-light"><th colspan="2"></th></tr>

				<?php // Fetch carousel imgs data
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`carousel_imgs`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="carousel_imgs">
						<th scope='col'>Carousel image (file name) #</th>
						<td>
							<textarea rows="1" maxlength="100" type="text" name="img_file_name" data-table="carousel_imgs" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['img_file_name']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>
		</tbody>
	</table>

	<label class="mt-3 mb-2 pl-3" for="form-2"><h2 class="font-weight-light">Условия работы и таблица часто задаваемых вопросов</h2></label>
	<table id="form-2" class="table table-bordered">
		<thead>
					<tr class="bg-light">
						<th scope='row'>День недели</th>
						<th scope='row'>Рабочее время</th>
						<th scope='row'>Время рассмотрения заявки</th>
					</tr>
		</thead>
		<tbody>
				<?php // Fetch short texts
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`work_schedule`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="work_schedule">
						<th scope='col' width="15%" ><?=$record['day_of_week']?></th>
						<td>
							<input maxlength="50" type="text" name="working_time" data-table="work_schedule" data-record-id="<?=$record['id']?>" class="form-control" value="<?=$record['working_time']?>">
						</td>
						<td>
							<input maxlength="50" type="text" name="app_time" data-table="work_schedule" data-record-id="<?=$record['id']?>" class="form-control" value="<?=$record['app_time']?>">
						</td>
					</tr>
				<?php endwhile; ?>

				<tr class="bg-light"><th colspan="3"></th></tr>

				<?	  // Fetch form tabs data
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`form_tabs`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="form_tabs">
						<th scope='col' >Tab #</th>
						<td>
							<textarea rows="5" maxlength="100" type="text" name="title" data-table="form_tabs" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['title']?></textarea>
						</td>
						<td>
							<textarea rows="5" maxlength="1000" type="text" name="content" data-table="form_tabs" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['content']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>

				<tr class="bg-light"><th colspan="3"></th></tr>

				<?    // Fetch FAQ data
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`faqs`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="faqs">
						<th scope='col' >Question #</th>
						<td>
							<textarea rows="4" maxlength="255" type="text" name="question" data-table="faqs" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['question']?></textarea>
						</td>
						<td>
							<textarea rows="4" maxlength="650" type="text" name="answer" data-table="faqs" data-record-id="<?=$record['id']?>" class="form-control"><?=$record['answer']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>
		</tbody>
	</table>

	<label class="mt-3 mb-2 pl-3" for="form-3"><h2 class="font-weight-light">Прайс - лист</h2></label>
	<table id="form-3" class="table table-bordered">
		<tbody>
				<?php // Fetch short texts
				$stmt = $pdo->query("SELECT * FROM `appletree_general`.`price_list`");
				while ($record = $stmt->fetch()):?>
					<tr class="borderless" data-record-id="<?=$record['id']?>" data-table-name="price_list">
						<th scope='col' width="10%">Offer #</th>
						<td width="20%">
							<textarea rows="2" maxlength="50" type="text" name="card_header" data-table="price_list" class="form-control" placeholder="Card header"><?=$record['card_header']?></textarea>
						</td>
						<td width="7%">
							<textarea rows="2" maxlength="8" type="text" name="price" data-table="price_list" class="form-control" placeholder="Price"><?=$record['price']?></textarea>
						</td>
						<th scope="col" width="10%">тенге\занятие</td>
						<td width="18%">
							<textarea rows="2" maxlength="50" type="text" name="condition" data-table="price_list" class="form-control" placeholder="Conditions"><?=$record['condition']?></textarea>
						</td>
						<td>
							<textarea rows="2" maxlength="255" type="text" name="note" data-table="price_list" class="form-control" placeholder="Note"><?=$record['note']?></textarea>
						</td>
					</tr>
				<?php endwhile; ?>
		</tbody>
	</table>
	<nav class="my-4 w-50 d-block">
		<button class="btn btn-success w-50 py-3 m-4" onclick="txtUpd('<?=$txtUpdProcessing_url?>')">Сохранить изменения</button>
	</nav>
</div>
	<!--

					<?php
				$i = 2;
				while ( $i < 4):?>
					<tr>
						<th scope='col' width="40%" ><?=$columnsData_array[$i]["column_comment"]?></th>
						<td>
							<input type="text" class="form-control" name="<?=$columnsData_array[$i]["column_name"]?>" required="true" value="<?=$recordData_array[$i]?>">
						</td>
					</tr>
				<?php $i++; endwhile;?>
				<tr>
					<th scope='col' width="40%" ><?=$columnsData_array[4]["column_comment"]?></th>
					<td>
						<select class="form-control" name="<?=$columnsData_array[4]["column_name"]?>">
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
						<th scope='col' width="40%" ><?=$columnsData_array[$i]["column_comment"]?></th>
						<td>
							<input type="text" class="form-control" name="<?=$columnsData_array[$i]["column_name"]?>" required="true" value="<?=$recordData_array[$i]?>">
						</td>
					</tr>
				<?php $i++; endwhile;?>
				<tr>
					<th scope='col' width="40%" ><?=$columnsData_array[8]["column_comment"]?></th>
					<td>
						<select class="form-control" name="<?=$columnsData_array[8]["column_name"]?>">
							<option value="1">Group</option>
							<option value="0">Private</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope='col' width="40%" ><?=$columnsData_array[9]["column_comment"]?></th>
					<td>
						<select class="form-control" name="<?=$columnsData_array[9]["column_name"]?>">
							<option value="Undetermined">Undetermined</option>
							<option value="Elementary">Elementary</option>
							<option value="Pre-Intermediate">Pre-Intermediate</option>
							<option value="Upper-intermediate">Upper-intermediate</option>
							<option value="Intermediate">Intermediate</option>
							<option value="Advanced">Advanced</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope='col' width="40%" ><?=$columnsData_array[11]["column_comment"]?></th>
					<td>
						<select class="form-control" name="<?=$columnsData_array[11]["column_name"]?>" >
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope='col' width="40%" ><?=$columnsData_array[10]["column_comment"]?></th>
					<td>
						<input type="text" disabled="true" class="form-control" value="<?=$recordData_array[10]?>">
						<input type="hidden" name="<?=$columnsData_array[10]["column_name"]?>" required="true" value="<?=$recordData_array[10]?>">
					</td>
				</tr>-->

				<?php /* foreach ($columnsData_array as $key => $value ):?>

				    <tr>
				    	<th scope='col' width="40%" ><?=$value["column_comment"]?></th>
				    	<td>
				    		<input type="text" class="form-control" name="<?=$value["column_name"]?>" required="true" value="<?=$recordData_array[$key]?>">
				    	</td>
				    </tr>

				<?php endforeach; */ ?>
<script>
	var flags = new Object();
	$(document).ready(function(){
		// Bind 'change' event function to input and textarea fields
		// as flags for every table of the database (where flags is an object with properties
		// set as table names and valued to 'true' or 'false')
		$('textarea, input').change(function(){ flags[$(this).attr('data-table')] = true;});
	});

	// The function sends data from input, textarea (from a single table, according to 'flags' trigger)
	// via ajax to processing
	function txtUpd(url){
		// Main array of database tables (basically a database)
		let database = new Object();
		if (jQuery.isEmptyObject(flags)){
			alert("No changes were made.");
			return;
		}
		// For each flag value in 'flags'
		$.each(flags, function(tableName, flagValue){
			// If flag value is 'true' (which means some data in 'tableName' has to be updated)
			if (flagValue) {
				// Single (database) table records array
				let tableRecordsArray = new Object();
				// Load input, textarea (of the table) data as an object of fields object
				// (with 'name' and 'value' properties equal to each input/textarea corresponding attribute values')
				// to 'tableRecordsArray' as properties (property name equal to corresponding record id)
				$("tr[data-table-name='"+tableName+"']").each(function(index, element){
					tableRecordsArray[$(element).attr("data-record-id")] = $(element).find("textarea,input").serializeArray();
				})

				// Extend 'database' object's 'tableName' property as an object of records for each table
				database[tableName] = new Object();
				// For each object in the 'tableRecordsArray'
				$.each(tableRecordsArray, function(recordId, fieldsArray){
					// Extend 'database' object's 'tableName' property-object's 'recordId' property
					// as an object of fields for the record
					database[tableName][recordId] = new Object();
					// Load input/textarea paired data as fields (= properties named as 'name' property value of the pair)
					// of a given record to the 'database'
					$.each(fieldsArray, function(index, dataPair){
						database[tableName][recordId][dataPair['name']] = dataPair['value'];
					})

				})
			}
		})
		$.ajax({
			url: "<?= $txtUpdProcessing_url ?>",
			type: 'POST',
			cache: false,
			data: database,
			beforeSend: function() {
				$("#loader_div").removeClass("hidden");
			},
			success: function(reply){
				if (reply == 0)
				{
					var result = alert("Update is successul!")
					// Clear flags
					flags = new Object();
					return;
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