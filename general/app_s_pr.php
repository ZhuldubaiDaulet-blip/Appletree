<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	$title = 'Application form for students!';
	$customStylesheets_array = array("back-link.style.css", "application_private.css", "loader.style.css");
	$customScripts_array = array("clickable_lists.js", "validate_list.js", "validate_text.js", "input_masking.js", "loader.js");
?>
<!-- BEGINNING OF HTML -->
<!DOCTYPE html>
<html lang="en">
	<?php require_once($head_ldp); ?>
<body>
	<!-- The loader -->
	<div id="loader_div" class="loader">
		<img src="<?=$spinner_src?>" alt="spinner">
	</div>
	<!-- The 'Back' link -->
	<?php require_once($backLink_ldp); ?>
	<br></br>
	<section id="section-form">
		<div class="mt-5">
			<form>
				<div class="container">
					<!-- A row for h2 -->
					<div class="row my-4 py-2">
						<h2>Пожалуйста, заполните все необходимые поля и нажмите "Зарегистрироваться"!</h2>
					</div>
					<!-- First row (name, surname, phone number) -->
					<div class="row py-3">
						<div class="col-xs-12 col-sm-8 col-md-4">
						    <label for="name-field">Имя</label>
						    <input type="text" maxlength="20" class="form-control" required="true" data-error-field="error_1" id="name-field" pattern="[A-Z]{1}[a-z]{0,20}">
							<small id="error_1" class="form-text text-danger d-none">Пожалуйста, напишите свое имя правильно, без пробелов</small>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-4">
						    <label for="surname-field">Фамилия</label>
						    <input type="text" maxlength="20" class="form-control" required="true" data-error-field="error_2" id="surname-field"  pattern="[A-Z]{1}[a-z]{0,20}" >
						    <small id="error_2" class="form-text text-danger d-none">Пожалуйста, напишите свою фамилию правильно, без пробелов</small>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-4">
						    <label for="phone-number-field">Контактный номер</label>
						    <input type="text" maxlength="19" class="form-control" required="true" data-error-field="error_3" id="phone-number-field" placeholder="+7 (___) ___-__-__" data-slots="_" pattern="^[+]7 [(]\d{3}[)] \d{3}-\d{2}-\d{2}$">
						    <small id="error_3" class="form-text text-danger d-none">Пожалуйста, напишите действительный номер телефона</small>
						</div>
					</div>
					<hr>
					<!-- Second row (additional phone number, level of education, sex) -->
					<div class="row py-3">
						<div class="col-xs-12 col-sm-8 col-md-4">
						    <label for="email-field">Адрес электронный почты</label>
						    <input type="text" maxlength="30" class="form-control" required="true" data-error-field="error_4"  id="email-field" aria-describedby="email_help" pattern="[a-z0-9._%+-]+@[a-z.-]+\.[a-z]{2,}$">
						    <small id="email_help" class="form-text text-muted">Мы будем использовать вашу электронную почту, чтобы сообщить вам об этом.</small>
						    <small id="error_4" class="form-text text-danger d-none">Пожалуйста, напишите правильный адрес электронной почты</small>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-4">
	    				    <label for="lvl-of-ed-field">Ваш уровень владения английским языком</label>
	    				    <select class="form-control" id="lvl-of-ed-field">
	    				    	<option value="Undetermined">Неопределенный</option>
	    				    	<option value="Beginner">Начинающий</option>
	    				    	<option value="Elementary">Начальный</option>
	    				    	<option value="Pre-Intermediate">Предпороговый уровень</option>
	    				    	<option value="Upper-intermediate">Пороговый продвинутый уровень</option>
	    				    	<option value="Intermediate">Пороговый уровень</option>
	    				    	<option value="Advanced">Уровень профессионального владения</option>
	    				    </select>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-4">
	    				    <label for="sex-field">Ваш пол</label>
	    				    <select class="form-control" id="sex-field">
	    				    	<option value="Male">Мужской</option>
	    					    <option value="Female">Женский</option>
	    					    <option value="Other">Другой</option>
	    				    </select>
						</div>
					</div>
					<hr>
					<!-- Third row (selectable schedule, information about classes schedule, birth year) -->
					<div class="row py-3">
						<div class="my-auto col-12 col-lg-7">
							<h5 class="my-3">Пожалуйста, выберите дни недели (не менее 2), в которые вы хотели бы проводить уроки</h5>
							<!-- The begining of the clickable list -->
							<div class="container-fluid mt-3 my-list">
								<ul class="row m-0 p-0 justify-content-around border rounded">
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3 active" id="weekday_all" exclusive= "true" data-error-field= "error_weekday">
										<p>Любые 2 дня</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3" id="weekday_1">
										<p>Понедельник</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3" id="weekday_2" >
										<p>Вторник</p>
										<input type="checkbox" class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3" id="weekday_3">
										<p>Среда</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3 " id="weekday_4">
										<p>Четверг</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3 " id="weekday_5">
										<p>Пятница</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3 " id="weekday_6">
										<p>Суббота</p>
										<input type="checkbox"  class="d-none">
									</li>
									<li class="py-md-4 li_weekday col-12 col-sm-6 col-md-3 " id="weekday_7" >
										<p>Воскресенье</p>
										<input type="checkbox" class="d-none">
									</li>
								</ul>
							</div>
							<!-- The end of the clickable list -->
							<small id="error_weekday" class="form-text text-danger d-none">Вы должны выбрать "Любые 2 дня" или, по крайней мере, 2 дня!</small>
						</div>
						<div class="col-xs-12 col-md-6 col-lg py-4">
							<div class="mb-3">
								<label for="birthyear-field">Год рождения</label>
								<input type="text" maxlength="5" class="form-control" id="birthyear-field"  pattern="^([1][9][2-9]|[2][0-2][0-9])\d{1}$" required="true" data-error-field="error_year">
								<small id="error_year" class="form-text text-danger d-none">Пожалуйста, напишите действительный год</small>
							</div>
							<div class="mb-3">
								<label for="preferences-field">Вы можете дополнительно объяснить свое желаемое расписание, чтобы мы могли принять решение добавить вас в один из существующих классов</label>
								<textarea class="form-control" id="preferences-field" aria-describedby="infoHelp" placeholder="Maximum - 500 characters" maxlength="500" style="resize: none;" rows="2"></textarea>
								<small id="infoHelp" class="form-text text-muted">
									Вы можете описать личную ситуацию, мы позже свяжемся с вами, чтобы сообщить об уроках.
								</small>
							</div>
						</div>
					</div>
					<hr>
					<!-- Fourth row (clickable list of time sessions, timetable) -->
					<div class="row">
						<!-- Timetable -->
						<div class="col-12 col-lg-7">
							<?php
							// Fetching data about time sessions of classes from the monday schedule table (for example)
							$sql = "SELECT `session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`monday` WHERE `id` = 0";
							$stmt = $pdo->query($sql);
							$sessionColumn1 = $stmt->fetch(PDO::FETCH_NUM);
							$sql = "SELECT `session1`,`session2`,`session3`,`session4`,`session5`,`session6` FROM `appletree_schedule`.`saturday` WHERE `id` = 0";
							$stmt = $pdo->query($sql);
							$sessionColumn2 = $stmt->fetch(PDO::FETCH_NUM);
							 ?>
							<table class="my-5 table table-striped border text-center">
								<caption><small> <i>Примечание:</i> В качестве примера приведем расписание на понедельник и субботу. Детали могут меняться в разные дни.</small></caption>
							  <thead>
							    <tr>
							      <th scope="col">Занятие</th>
							      <th scope="col">Время в будний день</th>
							      <th scope="col">Время в выходной день</th>
							    </tr>
							  </thead>
							  <tbody>
							    <?php foreach ($sessionColumn1 as $key=>$value): ?>
							    	<tr class="tr tr-<?=$key?>">
							    		<td scope="col"><?=$key>=3?"Evening-".($key-2):"Morning-".($key+1)?></td>
							    		<td scope="col"><?=$value?></td>
							    		<td scope="col"><?=$sessionColumn2[$key]?></td>
							        </tr>
							    <?php endforeach; ?>
							  </tbody>
							</table>
						</div>
						<!-- Clickable list of time sessions -->
						<div class="col-sm-12 col-md-12 col-lg-5 my-4 mt-lg-5 align-items-center">
							<h5>Пожалуйста, выберите удобное время занятия </h5>
							<p>(Вы можете выбрать много)</p>
	    				    <div class="my-3 my-list">
	    				    	<ul class="d-flex flex-wrap justify-content-center">
	    				    		<?php foreach ($sessionColumn1 as $key=>$value): ?>

	    				    			<li class="rounded border m-1 m-md-2 p-md-4 m-lg-1 mx-sm-2 col-sm-5 col-md-3 col-lg-5 p-3  li_time"  id="time_<?=$key?>" data-error-field="error_time">
	    				    			  <p class=""><?=$key>=3?"Evening-".($key-2):"Morning-".($key+1)?></p>
	    				    			</li>

	    				    		<?php endforeach; ?>
	    							<li class="rounded border m-1 m-md-2 m-lg-1 mx-sm-2 active col-sm-10 col-md-5 col-lg-7 p-3 li_time" id="time_any" exclusive="true">
	    								<p>В любое время</p>
	    							</li>
	    				    	</ul>
	    				    </div>
	    				    <small id="error_time" class="form-text text-danger d-none">Вы должны выбрать хотя бы один вариант!</small>
						</div>
					</div>
					<hr>
					<!-- Fifth row (pricing offers, supplementary information) -->
					<div class="row py-3">
						<div class="col-12 col-lg py-4	">
							<table class="table table-striped text-center border">
								<tbody>

								<?php
								// Fetching data about prices for lessons from the 'price_list' table
								$sql = "SELECT `card_header`,`price`,`condition`,`note` FROM appletree_general.price_list";
								$stmt = $pdo->query($sql);
								while ($row = $stmt->fetch(PDO::FETCH_OBJ)):
								?>
								   	<tr>
							    		<td class="font-weight-normal"><?= $row->card_header ?></td>
							    		<td class="font-weight-normal"><em><?= $row->condition ?></em></td>
							    		<td class="lead"><?= $row->price ?> тенге/занятие</td>
							        </tr>
								    <tr>
							       		<td class="font-weight-normal text-muted pt-0" colspan="3">
							       			<small><em><?= $row->note ?></small></em>
							       		</td>
							        </tr>

								<?php endwhile; ?>

								</tbody>
							</table>
						</div>
						<div class="col-12 col-md-10 col-lg-4 mb-4">
							<h5 class="my-3">Дополнительная информация</h5>
							<br>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="checkbox-1">
								<label class="form-check-label" for="checkbox-1">
									У меня есть WhatsApp, зарегистрированный на данный номер телефона
									<br>
									<small class="text-muted">(мы будем использовать его для связи с вами)</small>
								</label>
							</div>
							<br>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" checked="true" value="" id="checkbox-2">
								<label class="form-check-label" for="checkbox-2">
									Я хотел бы проверить свой английский
									<br>
									<small class="text-muted">(обязательно, если выбран параметр "Неопределенный".)</small>
								</label>
							</div>
						</div>
					</div>
					<hr>
					<!-- Control buttons -->
					<div class="row d-flex justify-content-center py-3">
						<button type="button" id="submit" class="btn btn-primary my-2" style="margin-right: 5%; min-width: 150px;">
							Регистрируйтесь!
						</button>
						<button type="reset" class="btn btn-secondary my-2 px-4">
							Сбросить форму заявки
						</button>
					</div>
				</div>
				<br></br>
	 		</form>
	 	</div>
	</section>
</body>
<!-- Importing jQuery and custom outsource scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	// Attaching 'click' function to the 'Register!' button via id and enabling clickable lists
	$(document).ready(function(){
		fix_loader("loader_div");
		if(set_click_listener("li_weekday") && set_click_listener("li_time"))
			$("#submit").click(submit);
		else
			$("#submit").attr("disabled", "true");
	})
	// The function converts chosen active (blue) list (sessions and days of week) elements
	// into a string as a description of choices
	function convertLists()
	{
		let a_string = "Chosen days of week: ";
		$("li.li_weekday.active > p").map(function(){
			a_string = a_string.concat($(this).text()).concat(", ");
		})
		a_string = a_string.substring(0,a_string.length-2).concat(". Chosen lessons time: ");
		$("li.li_time.active > p").map(function(){
			a_string = a_string.concat($(this).text()).concat(", ");
		})
		return a_string.substring(0,a_string.length-2).concat(".");
	}

	function submit()
	{
		// Local variable used to allow or prohibit further execution (validation var)
		let valid = validate_list($(".li_time"), 1) * validate_list($(".li_weekday"), 2) * validate_text($("input[type='text']"));
		// Form is submitted if every field passes validation (=> 'valid' is equal to 1, otherwise 'valid' would be equal to 0)
		if(valid)
		{
			// An array to keep the values of optional checkbox/radio input fields
			let opt_check = new Array(2);
			// Assign values for each of the checkbox/radio fields. Values are either 1 or 0,
			// since the input can only be True or False
			opt_check[0] = $("checkbox#checkbox-1").prop("checked")? 1:0;
			opt_check[1] = ($("#lvl-of-ed-field").val()=="Undetermined")? 1 : ($("#checkbox-2").prop("checked")? 1:0);
			// Define a new variable for a concatenated string from the 'convertLists' function
			// and actual provided preferences in the 'textarea' element
			let preferences = $("#preferences-field").val()==''? convertLists() : convertLists()
				.concat(" Additionally provided info:\n")
				.concat($("#preferences-field").val());
			// Sends data and either redirects the user or displays an alert according to the outcome
			$.ajax({
				url: "<?= $appProcessing_url ?>",
				type: 'POST',
				cache: false,
				data: {
					'name':$("#name-field").val(),
					'surname':$("#surname-field").val(),
					'phone_number':$("#phone-number-field").val(),
					'email':$("#email-field").val(),
					'ed_lvl':$("#lvl-of-ed-field").val(),
					'sex':$("#sex-field").val(),
					'birth_year':$("#birthyear-field").val(),
					'preferences':preferences,
					'opt_checkbox1':opt_check[0],
					'opt_checkbox2':opt_check[1],
					'application_type':'student',
					'group_ls':0
				},
				beforeSend: function() {
					$("#loader_div").removeClass("hidden");
				},
				success: function(data){
					// If the processing finished correctly
					if (data == 0)
					{
						var result = confirm("Your registration is successul! Press OK to return to main page.")
						// Redirect user if 'OK' was pressed
						if (result)
							window.location.replace("<?=$index_url?>");
						return;
					}
					else
					{
						alert(data);
						return;
					}
				}
			})
			$("#loader_div").addClass("hidden");
		}
	}
</script>
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>
</html>