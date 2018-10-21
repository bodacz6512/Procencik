<?php 
session_start();
$id = $_GET['id'];



$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/get_item_api.php?id=$id");
$result  = json_decode($content);

if(isset($_POST['imie'])){
	$imie = urlencode($_POST['imie']);
	$opinia = urlencode($_POST['opinia']);
	$opinia_number = $_POST['opinia_number'];
	$id = $_GET['id'];
	file_get_contents("http://serwer1869889.home.pl/projekt/api/opinie_api.php?add&a=$imie&b=$opinia&c=$opinia_number&d=$id");
}

if(isset($_GET['del_com'])){
	if(isset($_SESSION['logged'])){
		$iddelcom = $_GET['del_com'];
		$polaczenie->query("DELETE FROM `opinie` WHERE `id` = '$iddelcom'");
		
		
	}else{
		echo "Nie posiadasz takich uprawnień";
	}
}



?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<link rel="stylesheet" href="css/item.css?<?php echo time() ?>" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/fontawesome-stars.css" />
	<link rel="stylesheet" href="css/fontawesome-stars-o.css" />
	<title><?php echo ucfirst(strtolower($result->nazwa)) ?> | Procencik</title>

</head>
<body>


	<?php require("components/nav.php") ?>
	
	
	
	<div class="item-container">
	
		<div class="left">
	
			<h2><?php echo ucfirst(strtolower($result->nazwa)) ?></h2>
			
			<?php
			
				$adres =  urlencode($result->ulica.' '.$result->numer_lokalu);
				$map = str_replace("+", "%20", $adres);
				
				
			?>
			
			<div class="block-item">
				<div class="block-item-header"><h3 class="title_oceny">Ocena naszych użytkowników</h3></div>
				<div class="block-item-content">
				
					<div class="br-wrapper br-theme-fontawesome-stars-o">
						<div class="br-widget ocena-srednia">
						<?php
						
						$wynik =  file_get_contents("http://serwer1869889.home.pl/projekt/api/opinie_api.php?srednia&id=$id");
						if($wynik != 0)
						{
							$rozdzielenie = explode(".", $wynik);
							if(empty($rozdzielenie[1])){
								$rozdzielenie[1] = 0;
							}else{
								$rozdzielenie[1] = $rozdzielenie[1] * 10;
							}
						}else{
							$wynik = 0;
							$rozdzielenie[1] = 0;
						}
						
							?>
							<a data-rating-value="1" data-rating-text="1" <?php 
								if($wynik > 0.01 AND $wynik < 1){
									echo 'class="br-fractional br-fractional-'.$rozdzielenie[1].'"';
								}else if($wynik >= 1){
									echo 'class="br-selected"';
								}
							?>></a>
							<a data-rating-value="2" data-rating-text="2" <?php 
								if($wynik < 2){
									if($wynik >= 1.5){
										echo 'class="br-fractional br-fractional-'.$rozdzielenie[1].'"';
									}
								}else{
									echo 'class="br-selected"';
								}
							?>></a>
							<a data-rating-value="3" data-rating-text="3" <?php 
								if($wynik < 3){
									if($wynik >= 2.5){
										echo 'class="br-fractional br-fractional-'.$rozdzielenie[1].'"';
									}
								}else{
									echo 'class="br-selected"';
								}
							?>></a>
							<a data-rating-value="4" data-rating-text="4" <?php 
								if($wynik < 4){
									if($wynik >= 3.5){
										echo 'class="br-fractional br-fractional-'.$rozdzielenie[1].'"';
									}
								}else{
									echo 'class="br-selected"';
								}
							?>></a>
							<a data-rating-value="5" data-rating-text="5" <?php 
								if($wynik < 5){
									if($wynik >= 4.5){
										echo 'class="br-fractional br-fractional-'.$rozdzielenie[1].'"';
									}
								}else{
									echo 'class="br-selected"';
								}
							?>></a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="block-item">
				<div class="block-item-header"><h3 class="title_oceny">Lokalizacja</h3></div>
				<div class="block-item-content">
					<div class="mapouter"><div class="gmap_canvas"><iframe  id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $map; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div>
				</div>
			</div>
			
			<div class="block-item">
				<div class="block-item-header"><h3 class="title_oceny">Oceń fundację</h3></div>
				<div class="block-item-content">
				
					<form method="post">
					
						<div class="one-input">
							<label for="example">
								Twoja ocena
							</label>
							<select id="example" name="opinia_number">
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							</select>
						</div>
						
						<div class="one-input">
							<label for="imie">
								Twoje imię
							</label>
							<input id="imie" type="text" name="imie">
						</div>
						
						<div class="one-input">
							<label for="opinia">
								Twoja opinia
							</label>
							<textarea id="opinia" name="opinia" rows="5"></textarea>
						</div>
						<div class="one-input-submit">
							<input type="submit" value="Oceń" />
						</div>
					
					</form>
				</div>
			</div>
			
			
			<div class="block-item opinieblock">
				<div class="block-item-header"><h3 class="title_oceny">Oceny fundacji</h3></div>
				<div class="block-item-content">
				<?php
				$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/opinie_api.php?get&id=$id");
				if(!empty($content)){
				$resultopinie  = json_decode($content);
				$count_opinia =  count($resultopinie);
				for($i=0;$i<$count_opinia;$i++){
					$imie = $resultopinie[$i]->imie;
					$opinia = $resultopinie[$i]->opinia;
					$data = $resultopinie[$i]->data;
					$id_op =$resultopinie[$i]->id_op;
					$opinia_number = $resultopinie[$i]->opinia_number;
				?>
					<div class="opinia">
						<div class="opinia-img">
							<img src="img/user.png" />
						</div>
						<div class="opinia-content">
							<h4><?php echo $imie ?> <?php if(isset($_SESSION['logged'])) echo ' - <a style="color:red;" href="?id='.$id.'&del_com='.$id_op.'">[usuń]</a>'; ?></h4>
							<p class="tresc"><?php echo $opinia ?></p>
							<p class="data"><?php echo $data ?></p>
							<div class="br-wrapper br-theme-fontawesome-stars">
								<div class="br-widget zaznaczone">
									<a data-rating-value="1" data-rating-text="1" <?php if($opinia_number >= 1) echo 'class="br-selected br-current"'; ?>></a>
									<a data-rating-value="2" data-rating-text="2" <?php if($opinia_number >= 2) echo 'class="br-selected br-current"'; ?>></a>
									<a data-rating-value="3" data-rating-text="3" <?php if($opinia_number >= 3) echo 'class="br-selected br-current"'; ?>></a>
									<a data-rating-value="4" data-rating-text="4" <?php if($opinia_number >= 4) echo 'class="br-selected br-current"'; ?>></a>
									<a data-rating-value="5" data-rating-text="5" <?php if($opinia_number >= 5) echo 'class="br-selected br-current"'; ?>></a>
								</div>
							</div>
						</div>
					</div>
				<?php } }else{

				echo '<p>Brak ocen :/ Bądź pierwszy!</p>';
				}
				?>
					
				</div>
			</div>
			
		</div>


		<div class="right">

			<table class="dane_item">
			
				<tr>
					<th>Nazwa</th>
					<td><?php echo ucfirst(strtolower($result->nazwa)) ?></td>
				</tr>
				<tr>
					<th>Kategoria</th>
					<td><?php echo $result->kategoria_link ?></td>
				</tr>
				<tr>
					<th>NIP</th>
					<td><?php echo $result->nip ?></td>
				</tr>
				<tr>
					<th>KRS</th>
					<td><?php echo $result->krs ?></td>
				</tr>
				<tr>
					<th>REGON</th>
					<td><?php echo $result->regon ?></td>
				</tr>
			
			
			</table>
			
			<table class="dane_item">
			
				<tr>
					<th>Województwo</th>
					<td><?php echo ucfirst(strtolower($result->wojewodztwo)) ?></td>
				</tr>
				<tr>
					<th>Powiat</th>
					<td><?php echo ucfirst(strtolower($result->powiat)) ?></td>
				</tr>
				<tr>
					<th>Gmina</th>
					<td><?php echo ucfirst(strtolower($result->gmina)) ?></td>
				</tr>
				<tr>
					<th>Miasto</th>
					<td><?php echo ucfirst(strtolower($result->miasto)) ?></td>
				</tr>
				<tr>
					<th>Kod pocztowy</th>
					<td><?php echo $result->kod_pocztowy ?></td>
				</tr>
				<tr>
					<th>Adres</th>
					<td><?php echo $result->ulica;
					echo" ";
					echo $result->numer_lokalu;
					
						?>
					</td>
				</tr>
			</table>
			
			
			<table class="dane_item">
			
				<?php if(!empty($result->email)) { ?>
				<tr>
					<th>Email</th>
					<td><?php echo ucfirst(strtolower($result->email)) ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Data powstania</th>
					<td><?php echo $result->data_powstania ?></td>
				</tr>
				<tr>
					<th>Zdobyte pieniądze w 2017</th>
					<td><?php echo number_format($result->stan_konta, 2, ',', ' ')?> złoty</td>
				</tr>
			
			
			</table>
			
			
			
			
			
			
			
			
			<div class="cel_fundacji">
			
				<div class="top">
					Opis i cele działania
				</div>
				
				<div class="content">
				
					<?php 
					
					echo  $result->cel_dzialania;

					?>
				
				</div>
			
			</div>
		
		</div>
	
	
	</div>
	
	
	

	

	<?php require_once("components/footer.php") ?>
	<script src="js/jquery.barrating.min.js"></script>
	<script type="text/javascript">
   $(function() {
      $('#example').barrating({
        theme: 'fontawesome-stars'
      });
   });
   
   autosize($('textarea'));
</script>
</script>
</body>
</html>