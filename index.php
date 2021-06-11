<?php
	// Set the URI to clear index.php (without #something)
	if ($_SERVER['REQUEST_URI'] != '/index.php') {
		header('LOCATION: index.php');
	}
	// Import the basic config files
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	// The website title (set in 'head.php')
	$title = 'AppleTree main page';
	// Storing all necessary files in arrays for further images\02.jpg
	$customStylesheets_array = array('header.style.css', 'footer.style.css', 'loader.style.css');
	$customScripts_array = array('smooth_scroll.js', 'scroll_logo_resize.js', 'loader.js');
	// Storing little style adjustments for further amendment (set in 'head.php')
	$customStyles_css = '#section-faq { padding-bottom: 0px;  }  body{ background: url(images/6.jpg) no-repeat center center fixed;
        background-size: cover;} #section-welcoming { }';

	// Get relevant strings from the database table 'short_texts'
	$result = $pdo->query("SELECT `name`,`text` FROM `appletree_general`.`short_texts` WHERE `used_for` = 'index'");
	// Fetch all records in an associative array with first column values as keys
	$short_texts = $result->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
	// Assign values to corresponding variables used on the page
	$blockquoteCitation_text = $short_texts['blockquote_citation'][0];
	$welcoming_text = $short_texts['welcoming_text'][0];
	$blockquote_text = $short_texts['blockquote_text'][0];
	$scheduleNote_text = $short_texts['schedule_note'][0];
	$pricingNote_text = $short_texts['pricing_note'][0];
?>
<!DOCTYPE html>
<html lang="en">
<!-- Importing the head tag -->
<?php require_once($head_ldp); ?>

<body>
	<!-- Importing the header -->
	<?php require_once($header_ldp); ?>
	<!-- The loader -->
	<div id="loader_div" class="loader">
		<img src="<?=$spinner_src?>" alt="spinner">
	</div>


	<section id="section-home">
		<div id="carousel-1" class="carousel slide d-none d-md-flex"  data-ride="carousel" title="The slide will not change while your mouse is here :)">
			<div class="carousel-inner">
				<?php 	//------------------- Extracting carousel images from the database table 'carousel_imgs'
				$result = $pdo->query("SELECT `img_file_name` FROM `appletree_general`.`carousel_imgs`");
				// Fetching and displaying the results
				while($img_file = $result->fetch()['img_file_name']):
				?>
					<div data-interval="5000" class="carousel-item">
					<img src="<?= $imgs.$img_file ?>"  class="d-block w-100" alt="<?= $img_file ?>">
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</section>


	<section id="section-welcoming">
		<div class="container-fluid">

			<h2 id="welcoming_text" class=" text-center  text-white display-3 mb-5 "><?= $welcoming_text ?> </h2>
			<blockquote class="blockquote text-right">
				<p id="blockquote_text" class="mb-0 text-white"><?= $blockquote_text ?> </p>
				<?php if($blockquoteCitation_text !='')
						echo "<span class='blockquote-footer text-white '> <cite title='Source Title'>$blockquoteCitation_text</cite></span>";
				?>
			</blockquote>
			<br>
		</div>
	</section>

	<section id="section-schedule">
		<div class="py-4 bg-dark text-white container-fluid">
			<h2 class="my-3 py-3 text-center display-4">График работы</h2>
			<div class="row d-flex justify-content-center">
				<div class="col-12  col-md-6">
					<table class="my-5 table table-dark table-striped">
						<thead>
							<tr>
								<th scope="col">День недели</th>
								<th scope="col">Рабочее время</th>
								<th scope="col">Время рассмотрения онлайн-заявки</th>
							</tr>
						</thead>
					  	<tbody>
						<?php 	//------------------- Extracting schedule information from the database table 'work_schedule'
				  		// Fetch results
				  		$result = $pdo->query("SELECT `day_of_week`,`working_time`,`app_time` FROM appletree_general.work_schedule");
		  				// Display results by repeating the cycle for every fetched row in the table
				  		while($data = $result->fetch(PDO::FETCH_OBJ)):
				 		?>
				  			<tr>
				  				<td><?= $data->day_of_week ?></td>
				  				<td><?= $data->working_time ?></td>
				  				<td><?= $data->app_time ?></td>
				  			</tr>
				  		<?php endwhile; ?>
					  </tbody>
					</table>
					<br>
					<span id="schedule_note">
						<?php if($scheduleNote_text!='')
								echo "<p class='alert alert-success small'><strong>Примечание: </strong>$scheduleNote_text</p>";
						?>
					</span>
				</div>
			</div>
		</div>
	</section>

	<section id="section-pricing">
		<div class="container-fluid py-3">
			<h3 class="display-4 text-center py-2 my-2 text-white">Прайс - лист</h3>
			<div class="row d-flex justify-content-center text-center my-5 py-3 ">
				<?php 	//------------------- Extracting the pricing offers information
					$result = $pdo->query("SELECT `card_header`,`price`,`condition`,`note` FROM appletree_general.price_list");
		  			// Fetching and displaying the results
					while($data = $result->fetch(PDO::FETCH_OBJ)):
				?>
					<div class="price-card my-2 card col-7 col-sm-4 col-md-3 mx-3 px-0">
						<div class="card-header">
							<?= $data->card_header ?>
						</div>
						<div class="card-body">
							<strong>
								<h2><?= $data->price ?>тенге/занятие</h2>
								<p><?= $data->condition ?></p>
							</strong>
							<p class="text-left my-0"><small><em><?= $data->note ?></em></small></p>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="row text-center">
				<div class="col-8 col-lg-6 mx-auto">
					<span id="pricing_note">
						<?php if($pricingNote_text!='')
								echo "<p class='alert alert-success small'><strong>Примечание: </strong>$pricingNote_text</p>";
						?>
					</span>
				</div>
			</div>
		</div>
	</section>

	<section id="section-faq">
		<div class="container-fluid">
			<h3 class="my-4 py-3 display-4 text-center text-white ">Часто задаваемые вопросы</h3>
			<div class="accordion my-5 " id="accordion-item">
				<?php 	//------------------- Extracting questions and answers from the database table 'faqs'
		  		// Fetch results
		  		$result = $pdo->query("SELECT `question`,`answer` FROM appletree_general.faqs");
		  		// Display results
		  		// Temporary variable used to assign non-repeating 'id's for some elements
		  		$temp = 1;
		  		// Repeat for every fetched row in the table
		  		while($data = $result->fetch(PDO::FETCH_OBJ)):
		 		?>
		  			<div class="card ">
		  			  <div class="card-header " id="heading<?=$temp?>">
		  			    <p class="mb-0 ">
		  			      <button class="btn btn-link btn-block text-left collapsed text-info"  type="button" data-toggle="collapse" data-target="#collapse<?=$temp?>" aria-expanded="false" aria-controls="collapse<?=$temp?>">
		  			        <?= $data->question.PHP_EOL ?>
		  			      </button>
		  			    </p>
		  			  </div>
		  			  <div id="collapse<?=$temp?>" class="collapse" aria-labelledby="heading<?=$temp?>" data-parent="#accordion-item">
		  			    <div class="card-body">
		  			    	<?= $data->answer.PHP_EOL ?>
		  			    </div>
		  			  </div>
		  			</div>
		  		<?php
		  		$temp++;
		  		endwhile;
		  		?>
			</div>
		</div>
	</section>

	<!-- Importing the footer -->
	<?php require_once($footer_ldp); ?>
</body>
<!-- Importing jQuery, BootStrap's and custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		// Activating first carousel slide (necessary)
		$(".carousel-item").first().addClass("active");

		// This array stores different colors for futher usage
		var colors = ['rgba(208, 210, 208, 0.7)', 'rgba(107, 255, 107, 0.7)', 'rgba(255, 231, 81, 0.7)'];
		// Assigning background colors randomly for price list cards using the colors from the array above
		$(".price-card").each(function(index){
			$(this).css("background-color", colors[Math.floor(Math.random()*colors.length)]);
		})
		// Deactivating loader
		fix_loader("loader_div");
	})
</script>
<!-- Imporing other scripts -->
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>
</html>