// This function validates list via calling function 'check_list_limit' (declared below) and
// by checking input arguments validity;
// additionally, the function displays or hides error messages
// (by distributing Bootstrap class 'd-none' {display: none} to the 'error_field' element)
// and scrolls screen up to the corresponding list of elements if validation failed.
// Returns TRUE only if every element of the list has been successfully validated, else FALSE.
function validate_list(list, minimum)
{
	// This variable reserves the id (by the idea) of html element responsible for error message for further usage.
	var attr_val = list.first().attr("data-error-field");
	// Input arguments validation
	if(list.length < 2)
	{
		console.error("'validate_list' function: False input arguments!");
		return false;
	}
	if(attr_val === undefined || attr_val === "" )
	{
		console.error("'validate_list' function: Wrong 'data-error-field' attribute value!");
		return false;
	}
	var error_field = $("#"+attr_val);
	if (error_field.length === 0)
	{
		console.error("'validate_list' function: Failed to access the corresponding error field! Check the'data-error-field' attribute value.");
		return false;
	}
	if(isNaN(parseInt(minimum, 10)) || minimum < 0)
	{
		console.error("'validate_list' function: Wrong limitation argument!");
		return false;
	}
	// End of validation
	// ----------------------------------- Main 'if'. Deals with errors displaying
	if(check_list_limit(list, minimum))
	{
		error_field.addClass("d-none");
		return true;
	}
	else
	{
		error_field.removeClass("d-none");
		$([document.documentElement, document.body]).animate(
		{
			scrollTop: list.first().offset().top - 110
		}, 1000);
		return false;
	}
	// ----------------------------------- endif
}

// This function returns TRUE if argument 'list' (array of elements) has at least X
// (where X equals the value of 'min') elements or the exception element
// (which is determined by attribute 'exclusive' set to 'true') with class 'active'.
// The function return FALSE if minimum condition not achieved.
function check_list_limit(list, min)
{
	// Temporary variable used to evaluate number of 'active' elements
	var count = 0;
	list.map(function()
	{
		if($(this).attr("exclusive") === "true" && $(this).hasClass("active"))
		{
			count = min;
			return;
		}
		else if($(this).hasClass("active"))
		{
			count++;
		}
	})
	// Post-action checking
	if (count >=min)
	{
		return true;
	}
	else
	{
		return false;
	}
	
}