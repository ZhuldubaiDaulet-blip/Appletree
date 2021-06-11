function fix_loader(loader_id){
	$("#"+loader_id).addClass("hidden").on("animationend", function(){
			$("body").css("overflow","visible");
		});
}

