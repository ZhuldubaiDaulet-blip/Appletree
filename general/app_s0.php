<?php
	require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');

	// The URLs to the application webpages
	$appStdPrivate_url = $general_url .'app_s_pr.php';
	$appStdGroup_url = $general_url .'app_s_gr.php';

	$customStylesheets_array = array("back-link.style.css");
	$customStyles_css = ".choice_button{ width: 100%; font-size: 2rem;}";

?>

<!-- BEGINNING OF HTML -->
<!DOCTYPE html>
<html lang="en">
	<?php require_once($head_ldp); ?>
<body>
	<?php require_once($backLink_ldp); ?>
	<br></br>
	<div>
			<div class="container">
				<div class="row mb-2">
					<p class="alert display-4"><b>Для новых абитуриентов!</b></p>
				</div>
					<p class="alert alert-success display-4 pb-4">Пожалуйста, выберите, хотите ли вы проводить групповые или частные уроки</p>
					<div class="row mb-3">
						<div class="col-md"></div>
						<div class="col-12 col-sm-6 col-md-4 my-3">
							<a href="<?=$appStdGroup_url?>" class="btn btn-secondary py-4 choice_button">Групповые уроки</a>
						</div>
						<div class="col-12 col-sm-6 col-md-4 my-3">
							<a href="<?=$appStdPrivate_url?>" class="btn btn-secondary py-4 choice_button">Частные уроки</a>
						</div>
						<div class="col-md"></div>
					</div>
					<br>
			</div>
			<br></br>
 	</div>
</div>
</body>
</html>