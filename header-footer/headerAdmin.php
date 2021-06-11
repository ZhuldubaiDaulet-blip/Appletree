<?php
	$logo_src = $imgs . "logo.png";
	// Counting the number of applications and saving the value to display as a badge
	$stmt = $pdo->query("SELECT COUNT(id) FROM `appletree_personnel`.`app_teachers`");
	$numberOfApplications = $stmt->fetch(PDO::FETCH_NUM)[0];
	$stmt = $pdo->query("SELECT COUNT(id) FROM `appletree_personnel`.`app_students`");
	$numberOfApplications += $stmt->fetch(PDO::FETCH_NUM)[0];
	if ($numberOfApplications == 0)
		unset($numberOfApplications);
?>
<section id="section-header" style="padding: 0px;">
	<!-- Header content wrapper div -->
	<div id="headerdiv" class="d-flex flex-column flex-md-row align-items-center p-3 shadow mb-2" >
		<!-- Logo and title referencing to the main webpage -->
		<a href="<?=$index_url?>" class="text-decoration-none">
			<img src="<?=$logo_src?>" id="header-logo" hspace="0" alt="logo">
		</a>
		<div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100">
			<a class="py-2 px-3 btn mx-md-2 py-lg-3 main_text btn-secondary text-decoration-none" href="<?=$index_url?>">
				К главной странице
			</a>
			<!-- End of Logo and title -->
			<!-- Navigation row -->
			<div class="my-3 my-md-0 mx-md-2 col">
				<div class="container-fluid">
					<nav class="row d-flex justify-content-around">
						<button data-essence ="schedule" class="header-button col-xs-10 col-sm-5 col-lg-4 col-xl m-1 py-2 py-xl-4 font-weight-bold btn btn-info text-decoration-none">Расписание</button>
						<button data-essence ="applications" class="header-button col-xs-10 col-sm-5 col-lg-4 col-xl m-1 py-2 py-xl-4 font-weight-bold btn btn-info text-decoration-none">Заявки <span class="badge badge-warning"><?=$numberOfApplications?></span></button>
						<button data-essence ="members" class="header-button col-xs-10 col-sm-5 col-lg-4 col-xl m-1 py-2 py-xl-4 font-weight-bold btn btn-info text-decoration-none">Список</button>
						<button data-essence ="classes" class="header-button col-xs-10 col-sm-5 col-lg-4 col-xl m-1 py-2 py-xl-4 font-weight-bold btn btn-info text-decoration-none">Классы</button>
						<button data-essence ="frontEdit" class="header-button col-xs-10 col-sm-5 col-lg-4 col-xl m-1 py-2 py-xl-4 font-weight-bold btn btn-info text-decoration-none">Изменить</button>
					</nav>
				</div>
			</div>
			<!-- End of navigation -->
			<a class="btn logout_link mx-md-2 my-2 my-md-0 py-2 py-lg-3 px-3" href="<?=$logout_url?>">Выйти из системы</a>
		</div>
	</div>
</section>