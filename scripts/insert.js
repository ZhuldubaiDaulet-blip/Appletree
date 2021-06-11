// The funtion loads list of a members/ applicants (depending on the URL and role) into the '#content' div
function insertList(role, url){
	$("#loader_div").removeClass("hidden");
	$("#content").empty();
	$("#content").load(url, { role: role }, function( responseText, textStatus, jqXHR ){
		// Displaying error in console
		if (textStatus == "error") {
			let message = "'insertList' function error occured: ";
			console.error( message + jqXHR.status + " " + jqXHR.statusText );
		} else{
			$("#loader_div").addClass("hidden");
		}
	});
}

// The funtion loads CV of and applicant (of the given ID and role) from the file into the '#content' div
function insertCV(arg_id, role, url){
	$("#loader_div").removeClass("hidden");
	$("#content").empty();
	$("#content").load(url, { id: arg_id, role: role}, function( responseText, textStatus, jqXHR ){
		// Displaying error in console
		if (textStatus == "error") {
			let message = "'insertCV' function error occured: ";
			console.error( message + jqXHR.status + " " + jqXHR.statusText );
		} else{
			$("#loader_div").addClass("hidden");
		}
	});
}