<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<title>Nasze API</title>
</head>
<body>


	<?php require("components/nav.php") ?>
	
	
	<div class="our-api">
	
		<div class="head"><h2>Nasze api</h2>
		<p>Udostępniamy wam nasze API, możecie używac go do pobierania informacji o organizacjach mogących pobierać 1% podatku.</p>
		</div>
		
		<div class="api"><h3>Pobieranie informacji o organizacji</h3>
		
		<code style="display:block;width:450px;max-width:90%;margin:auto;word-break: break-all;">http://serwer1869889.home.pl/projekt/api/get_item_api.php?id={id}</code>
		<p>Gdzie {id} to id danej organizacji. Znajdziecie je w linku poszczególnej organizacji.</p></div>
		
		<div class="api"><h3>Pobieranie opinii o organizacji</h3>
		
		<code style="display:block;width:450px;max-width:90%;margin:auto;word-break: break-all;">http://serwer1869889.home.pl/projekt/api/opinie_api.php?get&id={id} </code>
		<p>Gdzie {id} to id danej organizacji. Znajdziecie je w linku poszczególnej organizacji.</p></div>
	
	
	
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