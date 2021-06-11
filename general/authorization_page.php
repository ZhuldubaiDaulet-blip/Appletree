<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($connection_config);
	$title = 'Authorization page';
	$customStylesheets_array = array("loader.style.css", "back-link.style.css");
	$customScripts_array = array("loader.js", "validate_single.js");
	$spinner_src = $imgs . "spinner.gif";

	// Redirect signed user from the page
	session_start();
	if (isset($_SESSION['user_login'])) {
		header("Location:$adminIndex_url");
	}
?>
<!DOCTYPE html>
<html>
<?php require_once($head_ldp); ?>
<body>
	<!-- The loader -->
	<div id="loader_div" class="loader hidden">
		<img src="<?=$spinner_src?>" alt="spinner">
	</div>
	<?php require_once($backLink_ldp); ?>

	<section id="section-form">
		<form>
			<div class="container">
				<div class="row py-3">
					<div class="col-xs-12 col-sm-8 col-md-4">
					    <label for="login-field">Логин</label>
					    <input name="login" type="text" class="form-control" id="login-field" pattern="[0-9a-zA-Z]{1,20}" required="true">
					</div>
				</div>
				<div class="row py-3">
					<div class="col-xs-12 col-sm-8 col-md-4">
					    <label for="password-field">Пароль</label>
					    <input name="password" type="password" class="form-control" id="password-field"  pattern="[0-9a-zA-Z]{1,}" required="true">
					</div>
				</div>
				<div class="row py-3">
					<div class="col-xs-10 col-sm-6 col-md-3">
						<input type="submit" id="submit" class="btn btn-primary my-2 w-100" value="Sign in!">
						<small id="error_0" class="form-text text-danger"></small>
					</div>
				</div>
			</div>
		</form>
	</section>
</body>
<!-- Importing jQuery, BootStrap's and custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	// Attaching the 'sign_in' function to the 'Sign in!' button click event via id
	$(document).ready(function(){
		$("#submit").click(sign_in);
		fix_loader("loader_div");
	})

	// The funtion executes Ajax and manages error displaying
	function sign_in(event)
	{
		event.preventDefault();
		// Get the error field
		var error_field = $("#error_0");
		// Empty the error text
		error_field.text("");
		if(validate_single('login-field') && validate_single('password-field'))
		{
			// Sends password and login values to the corresponding processing .php and
			// either redirects the user or displays an error according to the outcome
			$.ajax({
				url: '<?=$authorizationProcessing_url?>',
				type: 'POST',
				cache: false,
				data: { 'login':$("#login-field").val(), 'password':$("#password-field").val() },
				beforeSend: function() {
					$("#loader_div").removeClass("hidden");
				},
				success: function(data){
					if (data == 0)
					{
						window.location.replace("<?=$adminIndex_url?>");
						return;
					}
					else
					{
						error_field.text("Wrong login or password");
						return;
					}
				}
			})
		}
		// Clears password field and removes the loader
		$("input[name='password'").val("");
		$("#loader_div").addClass("hidden");
	}
</script>
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>
</html>