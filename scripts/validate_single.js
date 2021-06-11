// This function validates the input accessed by 'id' (string).
// Firstly checks if the field is empty, then if there is a pattern mismatch
// (via standart js ValidityState properties).
// Returns TRUE if validation is passed, else returns custom error message and FALSE
function validate_single(id)
{
	// Access check
	try
	{
		var object = document.getElementById(id);
		// Clearing custom validity error is required to prevent invalidity
		object.setCustomValidity('');
		var validityState = object.validity;
	}
	catch
	{
		console.error("'validate_single' function: Impossible to access the field or validity state!");
		return false;
	}
	// End of check

	if (validityState.valueMissing) 
	{
		object.setCustomValidity('Please fill the spaces!');
		object.reportValidity();
		return false;
	}
	if (validityState.patternMismatch)
	{
		object.setCustomValidity('Invalid symbols or incorrect pattern!');
		object.reportValidity();
		return false;
	}
	if (validityState.valid)
	{
		return true;
	}
	console.error("'validate_single' function: Unknown error!");
	return false;
}