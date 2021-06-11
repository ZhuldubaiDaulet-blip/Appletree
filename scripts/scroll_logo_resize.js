// This script resizes the logo size when user scrolls down 400px from the top of the document and
// attaches/detaches header to the screen ('display: fixed' property value)
window.onscroll = function() {scroll_screen()};
var logo = document.getElementById("header-logo");

function scroll_screen() {
	header = document.getElementById("headerdiv");
	section_home = document.getElementById("section-home");
	// Check if script successfully accessed necessary elements
	if (header === null || section_home === null)
	{
		console.error("'scroll_screen' function: impossible to access necessary elements by id!");
		return false;
	}
	// Managing header fixation
	if (window.pageYOffset > header.offsetTop)
	{
		header.classList.add("stuck");
		section_home.style.paddingTop = "182px";
	} else
	{
		header.classList.remove("stuck");
		section_home.style.paddingTop = "0px";
	}
	// Managing logo sizing
	if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400)
	{
		logo.style.width = "51px";
	    logo.style.height = "45px";
	  
	} else
	{
		logo.style.width = "170px";
		logo.style.height = "150px";
	}
}