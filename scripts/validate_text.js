// This function changes the background color of each element of 'fields' (jQuery array of elements)
// if it is correctly filled, and if any element does not pass checkValidity(), then scrolls up,
// as well as shows or hides error messages
// (by adding Bootstrap class 'd-none' {display: none} to a corresponding 'error' element, id of which
// should be given in 'data-error-field' attribute as a value string)
function validate_text(fields)
{
	// Input argument validation
	if (fields === undefined || fields.length < 1)
	{
		console.error("'validate_text' function: False input argument!");
		return false;
	}
	// End of validation
	
	// Assembling array of error fields. If at least 1 element of 'fields' does not have
	// required attribute 'data-error-field' value or the element is inaccessible, the function returns
	// FALSE and error text
	var errors = [];
	try
	{
		$(fields).each(function (index)
		{
			// This variable reserves the id (by the idea) of html element responsible for error message for further usage.
			var attr_val = $(this).attr("data-error-field");
			if(attr_val === undefined || attr_val === "" )
			{
				console.error("'validate_text' function: Impossible to access to every error field for the given list, check the attributes!");
				return false;
			}
			// Check if element by given id is inaccessible
			if ($("#"+attr_val).val() === undefined)
			{
				console.error("'validate_text' function: Failed to access the corresponding error field (iteration element is '%d')! Check the'data-error-field' attribute value.", index+1);
				return false;
			}
			errors.push($("#"+$(this).attr('data-error-field')));
		})
		// If number of input fields does not match number of error fields,
		// the function returns 'false'
		if (fields.length !== errors.length) { return false; }
		// Local variable used to prevent multiple 'animate()' scenarios
		var foo = true;
		// Local variable used to check if every field passed validation
		var passed = true;

		// ------------------- Main 'for' the loop. Goes through every element of 'fields' and adjusts the CSS styles
		for (var i = 0; i<fields.length; i++) 
		{
			if (fields[i].checkValidity())
			{
				fields[i].style.backgroundColor = "#ccf2ff";
				errors[i].addClass("d-none");
			} else
			{
				passed = false;
				fields[i].style.backgroundColor = "#ffffff";
				errors[i].removeClass("d-none");
				if (foo)
				{
					foo = false;
					$([document.documentElement, document.body]).animate(
					{
						scrollTop: fields.first().offset().top - 60
					}, 1000);
				}
			}
		}
		// ------------------- endfor
	}
	catch (error)
	{
		console.error("'validate_text' function: Failed to validate! Check if the input argument is a jQuery object.");
		return false;
	}
	
	if (passed)
	{
		return true;
	}
	else
	{
		return false;
	}
}