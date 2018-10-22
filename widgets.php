<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<title>Widgety</title>
</head>
<body>


	<?php require("components/nav.php") ?>
	
	
	<div class="our-api">
	
		<div class="head"><h2>Widgety</h2>
		<p>Dajemy wam narzędzie do poszerzenia wiedzy społeczeństwa na temat przekazania 1% podatku na cele charytatywne.<br>Wystarczy umieścić poniższy kod twojej stronie WWW a wygeneruje on widget danej fundacji.</p>
		</div>
		
		<div class="api"><h3>Widget</h3>
		
		<div class="widget-procencik" item-id="262" style="text-align:left;margin:auto;margin-bottom:20px;"></div>
					<script src="https://serwer1869889.home.pl/projekt/widgets/widget.js"></script>
		
		<code style="display:block;width:450px;max-width:90%;margin:auto;word-break: break-all;">&lt;div class="widget-procencik" item-id="TU_WPROWADZ_ID">&lt;/div>
							<br>&lt;script src="https://serwer1869889.home.pl/projekt/widgets/widget.js">&lt;/script></code>
		<p>W atrybucie `item-id` podajemy NUMER ID organizacji. Znajdziecie je w linku poszczególnej organizacji.<br><br>Widget można dowolnie modyfikować przy użyciu CSS, dzięki czemu nie będziecie mieli problemu z dopasowaniem go do waszej strony.</p></div>
		
	
	
	
	</div>
	

	

	<?php require_once("components/footer.php") ?>
	<script src="js/slider.js" /></script>
	<script>
	$('input[name="city"]').autoComplete({
    minChars: 1,
    source: function(term, suggest){
        term = term.toLowerCase();
        var choices = [<?php echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/index_api.php?get_all_city"); ?>];
        var matches = [];
        for (i=0; i<choices.length; i++)
            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
        suggest(matches);
		}
	});

</script>			
						
</body>
</html>