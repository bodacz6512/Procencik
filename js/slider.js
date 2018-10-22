$(document).ready(function() {


		 myFunction();





});

function myFunction() {
    setInterval(function(){
	
	
	if($(".img2").css("display") == "none"){
		
		$(".img1").css("display", "none"); 
		$(".img1").removeClass("animated fadeIn"); 
		
		$(".img2").css("display", "block"); 
		$(".img2").addClass("animated fadeIn"); 
		
		$(".index-main-bg").css("background-image", "url('img/slide2.jpg')"); 
		
	
		return true;
	}
	
	
	if($(".img1").css("display") == "none"){
		
		$(".img2").css("display", "none"); 
		$(".img2").removeClass("animated fadeIn"); 
		
		$(".img1").css("display", "block"); 
		$(".img1").addClass("animated fadeIn"); 
		$(".index-main-bg").css("background-image", "url('img/slide1.jpg')"); 
	
		return false;
	}
	
	
	
	}, 5500);
	
}

