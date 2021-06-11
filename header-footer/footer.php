<?php
	$sql = "SELECT `name`,`text` FROM `appletree_general`.`short_texts` WHERE `used_for` = 'footer'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$short_texts = $stmt->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);

	// Assign values to the corresponding variables used in footer
	$slogan_text = $short_texts['slogan_text'][0];
	$email_text = $short_texts['email_text'][0];
	$phone_text = $short_texts['phone_text'][0];
 ?>
<section id="section-footer">
	<footer>
	  <br></br>
	  <div class="container-fluid pt-5 px-5 text-light">
	  	<div class="row mb-2 mx-3">
	  		<div class="col-md-3">
	  			<p class="p-2"><b>AppleTree</b></p>
	  			<p class="text-muted small">Kostanay, 2020-2021. Made by Daulet with Bootstrap 4.5</p>
	  		</div>
	  		<div class="col-12 col-md-9">
	  			<div class="container-fluid">
	  				<div class="row mb-4">
	  					<h2 class="px-3"><b id="slogan_text"><?= $slogan_text ?></b></h2>
	  				</div>
	  				<div class="row d-flex no-wrap">
	  					<!-- Contacts -->
	  					<div class="col">
	  						<p class="text-muted"><b>Связаться с нами по email</b></p>
	  						<br>
	  						<p><u id="email_text"><?= $email_text ?></u></p>
	  					</div>
	  					<div class="col">
	  						<p class="text-muted"><b>WhatsApp</b></p>
	  						<br>
	  						<p><u id="phone_text"><?= $phone_text ?></u></p>
	  					</div>
	  					<!-- End of contacts -->
	  					<div class="col">
	  						<!-- Social media section -->
	  						<div class=" d-flex justify-content-around mb-4 row">
	  							<?php 	//------------------- Extracting references and image file names from the database table 'social_media'
	  							//Fetch results
	  							$result = $pdo->query("SELECT `img_file_name`,`href` FROM `appletree_general`.`social_media`");
	  							//Display results
	  							while($data = $result->fetch(PDO::FETCH_OBJ)):
	  							?>
	  								<div class="col p-0">
	  									<a href="<?= $data->href ?>"><img class="social-media-img" src="<?= $imgs.$data->img_file_name ?>" alt="<?= $data->alt ?>"></a>
	  								</div>
	  							<?php endwhile; ?>
	  						<!-- End of social media references -->
	  						</div>
	  						<div>
	  							<p class="text-muted mb-1"> ALL RIGHTS RESERVED</p>
	  							<p class="text-muted mb-1"> DESIGNED SPECIFICALLY FOR EXAMINATION</p>
	  						</div>
	  					</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	<div class="pb-3 mb-4 mx-5 color-bcbec0">
	  		<small>
	  			<b>Созданный для дипломной работы</b>
	  		</small>
	  	</div>
	  	<br>
	  </div>
	</footer>
</section>