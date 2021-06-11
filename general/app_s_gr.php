<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	$title = 'Application form for students!';
	$customStylesheets_array = array("back-link.style.css", "application_private.css", "loader.style.css");
	$customScripts_array = array("custom_validation.js", "validate_text.js", "input_masking.js", "loader.js");
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
						    <label for="phone-number-field">Контактный телефон</label>
						    <input type="text" maxlength="19" class="form-control" required="true" data-error-field="error_3" id="phone-number-field" placeholder="+7 (___) ___-__-__" data-slots="_" pattern="^[+]7 [(]\d{3}[)] \d{3}-\d{2}-\d{2}$">
						    <small id="error_3" class="form-text text-danger d-none">Пожалуйста, напишите действительный номер телефона</small>
						</div>
					</div>
					<hr>
					<!-- Second row (additional phone number, level of education, sex) -->
					<div class="row py-3">
						<div class="col-xs-12 col-sm-8 col-md-4">
						    <label for="email-field">Адрес электронный почты</label>
						    <input type="text" maxlength="30" maxlength="50" class="form-control" required="true" data-error-field="error_4"  id="email-field" aria-describedby="email_help" pattern="[a-z0-9._%+-]+@[a-z.-]+\.[a-z]{2,}$">
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
	    				    	<option value="Intermediate">Пороговый</option>
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
					<!-- Third row (timetable, timetable explanation, birth year) -->
					<div class="row py-3">
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
						<div class="col py-4 flex-lg-column">
							<div class="col-xs-12 col-md-6 col-lg mb-5">
								<label for="birthyear-field">Год рождения</label>
						    	<input type="text" maxlength="5" class="form-control" id="birthyear-field"  pattern="^([1][9][2-9]|[2][0-2][0-9])\d{1}$" required="true" data-error-field="error_year">
						    	<small id="error_year" class="form-text text-danger d-none">Пожалуйста, напишите действительный год</small>
							</div>
						    <div class="col">
						    	<label for="preferences-field">Пожалуйста, объясните свое желаемое расписание, чтобы мы могли принять решение добавить вас в один из существующих классов</label>
								<textarea class="form-control" id="preferences-field" required="true" data-error-field="error_preferences" aria-describedby="infoHelp" placeholder="Maximum - 700 characters" maxlength="700" style="resize: none;" rows="5"></textarea>
								<small id="infoHelp" class="form-text text-muted">
									Вы можете указать наиболее удобные дни недели и время для ваших занятий, позже мы свяжемся с вами, чтобы сообщить о свободных местах.
								</small>
								<small id="error_preferences" class="form-text text-danger d-none">Пожалуйста, не оставляйте это место пустым</small>
						    </div>
						</div>
					</div>
					<hr>
					<!-- Fourth row (pricing offers, supplementary info) -->
					<div class="row py-3">
						<div class="col-12 col-lg py-4">
							<!-- The price list table -->
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
							    		<td class="lead"><?= $row->price ?> тенге\занятие</td>
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
								<input class="form-check-input" type="checkbox" value="" id="whatsapp-field">
								<label class="form-check-label" for="whatsapp-field">
									У меня есть WhatsApp, зарегистрированный на данный номер телефона
									<br>
									<small class="text-muted">(мы будем использовать его для связи с вами)</small>
								</label>
							</div>
							<br>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" checked="true" value="" id="test-field">
								<label class="form-check-label" for="test-field">
									Я хотел бы проверить свой английский
									<br>
									<small class="text-muted">(обязательно, если выбрано "Неопределенное")</small>
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
	// Attaching 'click' function to the 'Register!' button via id
	$(document).ready(function(){
		fix_loader("loader_div");
		$("#submit").click(submit);
	})

	function submit()
	{
		// Form is submitted if every field passes validation (through imported function)
		if(validate_text($("input[type='text'], textarea")))
		{
			// An array to keep the values of optional checkbox/radio input fields
			let opt_check = new Array(2);
			// Assign values for each of the checkbox/radio fields. Values are either 1 or 0,
			// since the input can only be True or False
			opt_check[0] = $("#checkbox-1").prop("checked")? 1:0;
			opt_check[1] = ($("#lvl-of-ed-field").val()=="Undetermined")? 1 : ($("#checkbox-2").prop("checked")? 1:0);
			// Define a new variable for a concatenated string from the 'convertLists' function
			// and actual provided preferences in the 'textarea' element
			let preferences = $("#preferences-field").val();
			// Sends sends data and either redirects the user or displays an alert according to the outcome
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
					'group_ls':1
				},
				beforeSend: function() {
					$("#loader_div").removeClass("hidden");
				},
				success: function(data){
					if (data == 0)
					{
						var result = confirm("Your registration is successul! Press OK to return to main page.")
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