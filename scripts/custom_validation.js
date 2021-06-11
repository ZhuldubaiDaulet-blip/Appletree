// This function is designed to validate Birth Year field. It returns TRUE only if entered year value is between 1920 and current year.
// If the value does not belong to years period, the error is displayed and screen is moved to the corresponding field.
function validate_birthYear(id)
{
	// Declaring variables and assuring proper access to html elements.
	var birthyear = document.getElementById(id);
	if(birthyear === null)
	{
		console.error("'validate_birthYear' function: Failed to access the element of given id!\nGiven argument value is: " + id);
		return false;
	}
	// This variable reserves the id (by the idea) of html element responsible for error message for further usage.
	var attr_val = $("#"+id).attr('error-field');
	if(attr_val === undefined || attr_val === "" )
	{
		console.error("'validate_birthYear' function: Wrong 'error-field' attribute value!");
		return false;
	}
	var error_field = $("#"+attr_val);
	if (error_field.val() === undefined)
	{
		console.error("'validate_birthYear' function: Failed to access the corresponding error field! Check the'error-field' attribute value.");
		return false;
	}
	// End of access check
	// ----------------------- Main 'if'. Executes logic described above.
	if (parseInt(birthyear.value) > new Date().getFullYear()|| parseInt(birthyear.value) < 1920)
	{
		error_field.removeClass("d-none");
		birthyear.style.backgroundColor = "#ffffff";
		$([document.documentElement, document.body]).animate(
		{
			scrollTop: error_field.offset().top - 85
		}, 1000);
		return false;
	}
	else // ------------------ If validation is successful:
	{
		return true;
	}
	// endif
}