<?php
	// The URLs of the 'src's and 'href's used in the header
	$appMain_url = $general_url . 'app_main.php';
	$authorizationPage_url = $general_url . 'authorization_page.php';
	$logo_src = $imgs . "logo.png";
	$header_href = $index_url . "#section-header";
	$contacts_href = $index_url . "#section-footer";
	$pricing_href = $index_url . "#section-pricing";
	$faq_href = $index_url . "#section-faq";
?>
<section id="section-header" style="padding: 0px;">
	<nav class="navbar navbar-default d-md-none" role="navigation">

	<div class="container-fluid">
    <!—Название сайта и кнопка раскрытия меню для мобильных-->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Название сайта</a>
    </div>
     <!—Само меню-->
 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
 <ul class="nav navbar-nav">
 <li class="active"><a href="schedule.php">Расписание</a></li>
 <li><a href="<?=$contacts_href?>">Контакты</a></li>
 <li><a href="<?=$pricing_href?>">Прайс - лист</a></li>
 <li><a href="<?=$faq_href?>">FAQ</a></li>
 <li><a href="<?=$authorizationPage_url?>">Администрация</a></li>
 <li><a href="<?=$appMain_url?>">Заявки</a></li>
 </ul>
 </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
		<!-- Header content wrapper div -->
		<div id="headerdiv" class="flex-column flex-md-row d-none d-md-flex align-items-center p-3 shadow" >
			<!-- Logo and title referencing to the main webpage -->
			<a href="<?=$header_href?>" class="text-decoration-none">
				<img src="<?=$logo_src?>" id="header-logo" hspace="0" alt="logo">
			</a>
			<h4  class="mr-md-auto ml-md-2" >
				<a class="text-decoration-none main_text" href="<?=$header_href?>">
					AppleTree English courses!
				</a>
			</h4>
			<!-- End of Logo and title -->
			<!-- Navigation row -->
			<navbar class="container-fluid-my-2 my-md-0 mr-md-2">
				<a class="p-2 text-light text-decoration-none" href="schedule.php">Расписание</a>
			    <a class="p-2 text-light text-decoration-none" href="<?=$contacts_href?>">Контакты</a>
			    <a class="p-2 text-light text-decoration-none" href="<?=$pricing_href?>">Прайс - лист</a>
			    <a class="p-2 text-light text-decoration-none" href="<?=$faq_href?>">FAQ</a>
			    <a class="p-2 text-light text-decoration-none" href="<?=$authorizationPage_url?>">Администрация</a>
			</navbar>
			<!-- End of navigation row -->
			<a class="btn application_link mr-md-2 my-2 my-md-0 ml-md-5" href="<?=$appMain_url?>">Заявки</a>
		</div>
</section>