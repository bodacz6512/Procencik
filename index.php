<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<title>Procencik - Znajdź fundację 1% podatku</title>
</head>
<body>


	<?php require("components/nav.php") ?>
	<div class="index-main-bg" style="background-image:url('img/slide1.jpg');background-size:cover;background-attachment:fixed;">
		<div class="index-main">
		
			<div class="index-main-text">
			
				<h2>Twój 1% podatku</h2>
				<p>Przekazywanie 1% podatku może odmienić życie wielu ludzi, a czasem nawet je uratować.<br></br> Każda osoba, która ma taką możliwość powinna zdecydować, gdzie chce przekazać swój procent.</p>
				
				<form method="get" action="search.php">
					<label for="city"><span>Wyszukaj fundację w twoim mieście</span></label>
					<input type="text" id="city" name="city" placeholder="Nazwa miasta">
					<input type="submit" value="Wyszukaj">
				</form>
			</div>
			
			<div class="index-main-img">
				<img src="img/slide1.jpg" class="img1"/>
				<img src="img/slide2.jpg" class="img2" style="display:none;"/>
			</div>
			
		</div>
	</div>
	
	<div class="index-second">
	
		<div class="index-second-text">
		
			<h2>Jawne dochody</h2>
			<p>Wgląd w dochody danych fundacji w poprzednim roku. <br>Dzięki temu łatwiej będzie ci zdecydować na jaką fundację przekazać swój 1% podatku!</p>
			
			
			<h3>Top 3</h3>
			
			<table>
				<tr>
					<th>Nazwa fundacji</th>
					<th>Kwota</th>
				</tr>
				
				<?php 
				
				
					$content = file_get_contents("http://serwer1869889.home.pl/projekt/api/money_api.php?get_money&count=3&offset=0");
					$res = json_decode($content);
					$liczba_fundacji = count($res);
					for($i=0;$i<$liczba_fundacji;$i++){
						echo "<tr>";
						echo '<td><a href="item.php?id='.$res[$i]->id.'">'.$res[$i]->nazwa.'</a></td>';
						echo "<td>".number_format($res[$i]->stan_konta, 2, ',', ' ').' PLN</td>';
						echo "</tr>";
					}
				
				?>
				
				
			
			</table>
			
			<p class="see_full_list"><a href="list_money.php">Zobacz pełną listę</a></p>
		</div>
		
		<div class="index-second-img">
			<img src="img/pieniadze.jpg"/>
		</div>
		
	</div>
	
	
	
	
	
	
	
	
	<div class="index-third-bg" style="background-image:url('img/ludzie.jpg');background-size:cover;background-attachment:fixed;">
		<div class="index-third">
		
			<div class="index-third-text">
			
			<?php
				
				$content = file_get_contents("http://serwer1869889.home.pl/projekt/api/money_api.php?get_all_money_org=true");
				$res = json_decode($content);
				$total = $res->total;
				$liczba_fundacji = $res->liczba_fundacji;
				
			?>
				<h2>Razem możemy więcej!</h2>
				<p><br>Razem zebralismy : <span class="odliczanie"><?php echo number_format($total, 2, ',', ' ') ?> </span>złoty.<br>
				<br><br>Średnio jedna fundacja zyskała <?php echo number_format($total/$liczba_fundacji, 2, ',', ' ')   ?> złoty.</p>
				
			</div>
			
			<div class="index-third-img">
				<img src="img/ludzie.jpg" />
			</div>

		</div>
	</div>

	

	<?php require_once("components/footer.php") ?>
	<script src="js/slider.js?dx" /></script>
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