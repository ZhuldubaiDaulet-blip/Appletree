// Add smooth scrolling to any links with hashes
$(document).ready(function(){
	  try
	  {
	  	$("a").click(smooth_scroll);
	  }
	  catch
	  {
	  	console.error("'smooth_scroll' function: No elements found!");
	  }
	});

function smooth_scroll(event)
{
	let location = window.location.protocol+'//'+window.location.host+window.location.pathname;
	if (this.getAttribute('href') && this.getAttribute('href').startsWith(location))
	{
	  // Prevent default anchor click behavior
	  event.preventDefault();
	  // ------------------ Main 'if'. Works only if links contain hash
	  if (this.hash !== "" && !$(this).hasClass("disabled"))
	  {
	    // Store the html link and its hash
	    let hash = this.hash;
	    let link = $(this);
	    let href = link.attr('href');
	    // Setting the duration time for the animation in milliseconds
	    let var_duration = 1500;
	    // Assigning animation
	    link.addClass("disabled");
	    $('html, body').animate(
	    {
	    	scrollTop: $(hash).offset().top
	    },
	    {
	    	duration: var_duration,
 			complete: function() {
	 	  		// Add hash (#) to URL when done scrolling (default click behavior)
	      		window.location.hash = hash;
	      		link.removeClass("disabled");
	    	}
	    }
 		);
	  }
	  else
	  {
	  	console.error("'smooth_scroll' function: Empty link hash.");
	  }
	  // -------------------- End of 'if'
	}
}