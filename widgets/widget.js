(function() {

// Localize jQuery variable
var jQuery;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src",
        "https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    if (script_tag.readyState) {
      script_tag.onreadystatechange = function () { // For old versions of IE
          if (this.readyState == 'complete' || this.readyState == 'loaded') {
              scriptLoadHandler();
          }
      };
    } else {
      script_tag.onload = scriptLoadHandler;
    }
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
    jQuery = window.jQuery;
    main();
}

/******** Called once jQuery has loaded ******/
function scriptLoadHandler() {
    // Restore $ and window.jQuery to their previous values and store the
    // new jQuery in our local jQuery variable
    jQuery = window.jQuery.noConflict(true);
    // Call our main function
    main(); 
}

/******** Our main function ********/
function main() { 
    jQuery(document).ready(function($) { 
        /******* Load CSS *******/
        var css_link = $("<link>", { 
            rel: "stylesheet", 
            type: "text/css", 
            href: "https://serwer1869889.home.pl/projekt/widgets/style.css?xd" 
        });
        css_link.appendTo('head');        

        /******* Load HTML *******/
		//var id = $(".widget").html();
		var id = $(".widget-procencik").attr( "item-id" );
        var jsonp_url = "https://cors.io/?https://serwer1869889.home.pl/projekt/api/get_item_api.php?id="+id;
        $.getJSON(jsonp_url, function(data) {
          $('.widget-procencik').html('<a href="http://serwer1869889.home.pl/projekt/item.php?id='+id+'"><div class="header-widget-procencik">Przekaż swój 1% podatku na :</div><div class="title-widget-procencik">' + data.nazwa + '</div><div class="krs-widget-procencik">KRS : ' + data.krs + '</div><div class="brand-logo-widget-procencik">Procencik</div></a>');
        });
    });
}

})(); // We call our anonymous function immediately