<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);

	// The group or private lesson choice (student pre-application) webpage URL
	$appStd_url = $general_url . 'app_s0.php';
	$appTch_url = $general_url .'app_t.php';

	$title = 'Apply now!';
	$customStylesheets_array = array("header.style.css", "footer.style.css");
	$customStyles_css = ".choice_button{ width: 100%; padding-top: 20px; padding-bottom: 20px;	font-size: 2rem; } #section-main{ padding-bottom: 0px; }";
?>


<!DOCTYPE html>
<html lang="en">
	<?php require_once($head_ldp); ?>
<body>
 	<?php require_once($header_ldp); ?>
	<section id="section-main">
		<div class="container py-5">
			<div class="row">
					<!-- Creating and filling teacher application form -->
				<div class="col-auto d-flex justify-content-center">
					<p class="alert alert-success display-4">Для новых претендентов! Пожалуйста, выберите свою роль!</p>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-12 col-md-4 my-3">
					<a href="<?=$appTch_url?>" class="btn btn-secondary choice_button">Я учитель</a>
				</div>
				<div class="col-12 col-md-4 my-3">
					<a href="<?=$appStd_url?>" class="btn btn-secondary choice_button">Я студент</a>
				</div>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<p class="alert alert-success display-4">Для определения уровня английского пройдите тест!</p>
			<div class="col - 12 col-md-4 my-4">
					<a href="https://englex.ru/your-level/placement/" target="_blank" class="btn btn-secondary choice_button">Тест</a>
				</div>
		</div>

	</section>
	<?php require_once($footer_ldp); ?>
</body>
</html>