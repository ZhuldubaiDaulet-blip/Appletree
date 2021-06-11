<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
	require_once($connection_config);
	session_start();
	// Block access for unathorized users
	if (!isset($_SESSION['user_login'])) {
		header("Location:$authorizationPage_url");
	}
	$title = 'Administration page';
	$customScripts_array = array('loader.js');
	$customStylesheets_array = array('headerAdmin.style.css', 'loader.style.css', 'tables.style.css');
?>
<!DOCTYPE html>
<html>
<?php require_once($head_ldp); ?>
<body>
	<?php require_once($headerAdmin_ldp); ?>
	<div id="loader_div" class="loader">
		<img src="<?=$spinner_src?>" alt="spinner">
	</div>
	<!-- The div in which modules are loaded -->
	<div id="body">
		
	</div>
	<!-- Empty div to prevent instant scrolls due to page offset shifts -->
	<div style="margin-bottom: 45vw;"></div>
</body>
<!-- Importing jQuery, BootStrap's and custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	// Binding the 'loadPage' function to the 'Sign in!' button click event via class
	$(document).ready(function(){
		$(".header-button").click(loadPage);
		fix_loader("loader_div");
	})

	// Executes Ajax and manages error displaying
	function loadPage(event, role = null)
	{
		event.preventDefault();
		$("#loader_div").removeClass("hidden");
		// Get the module id from the button's attrubite
		let data = $(this).attr("data-essence");
		// The function sends the id to the router file and loads a module
		// (+ passes the additional argument, URL of this page) according to the response.
		// Console displays error if 'False' was returned
		$.ajax({
			url: "<?=$router_url?>",
			type: 'POST',
			cache: false,
			data: {'temp': data},
			success: function(response){
				if (response=="False"){
					console.error("'loadPage' function: Unknown url submitted!");
					return;
				}
				try	{
					$("#body").empty();
					$("#body").load( response, {'url':"<?=$url?>", 'role': role} );
				}
				catch(error)
				{
					console.error("'loadPage' function: "+error);
				}
			}
		})
		$("#loader_div").addClass("hidden");
	}
</script>
<?php foreach ($customScripts_array as $value){	echo "<script src='$js$value'></script>".PHP_EOL; } ?>
</html>