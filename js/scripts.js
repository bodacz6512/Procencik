function menu(){
	
	if($(".menu-overlay").css("display") == "none"){
		$(".menu-overlay").css("display", "block");
		$(".nav-mobile").css("display", "block");
		return true;
	}else{
		$(".menu-overlay").css("display", "none");
		$(".nav-mobile").css("display", "none");
		return false;
	}
	
}


function filtr(){
	
	if($(".categories-search").css("display") == "none"){
		$(".categories-search").css("display", "block");
		$(".overlay-filtr-mobile").css("display", "block");
		return true;
	}else{
		$(".categories-search").css("display", "none");
		$(".overlay-filtr-mobile").css("display", "none");
		return false;
	}
	
}