// This function attaches click listener function on every element of the list (accessed by 'list_class').
// The function returns TRUE if handling has been successful, otherwise FALSE.
function set_click_listener(list_class)
{
	var list = $("." + list_class);
	// Input argument validation
	if(list === undefined || list.length < 1)
	{
		console.error("'set_click_listener' (clickable_lists.js) function: No elements with such a class name!")
		return false;
	}

	// Main 'if'. Manages exclusive list elements (with attrubite 'exclusive' = 'true') and regular elements toggle.
	// No exclusive element can be 'active' (to have bootstrap class 'active') together with any other element.
	if (list.click(function(){
			try
			{
				if ($(this).attr("exclusive") === "true")
				{
					if ($(this).hasClass("active"))
					{
						$(this).removeClass("active");
						return true;
					}
					list.map(function(){
						$(this).removeClass("active");
					})
					$(this).addClass("active");
					return true;
				}
				else
				{
					if ($(this).hasClass("active"))
					{
						$(this).removeClass("active");
						return true;
					}
					else
					{
						$(this).addClass("active");
						$("." + list_class + "[exclusive = 'true']").removeClass("active");
						return true;
					}
				}
			}
			catch // --------- If error has occured:
			{
				return false;
			}
		}))
	{	// ------------------- If successful:
		return true;
	}
	// endif
	return false;
}