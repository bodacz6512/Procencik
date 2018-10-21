<?php 

session_start();
require("connect.php");

$id = $_GET['id'];

if(!isset($_SESSION['logged'])){
	header("location: login.php");
	exit;
}

if(isset($_POST['nazwakategorii'])){
	$name_cat = $_POST['nazwakategorii'];
	$img1 = $_POST['imgkategorii'];
	
	
	$main_img = $_FILES['plik'];
	$time = time();
	$location = "upload";
	$tmp_nazwa = $main_img["tmp_name"];
	$nazwa = $main_img["name"];
	

	$nazwa1 = strtr($nazwa, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'EOASLZZCNeoaslzzcn');
	$img2 = "$location/$time.$nazwa1";
	
	if(empty($nazwa)){
		$mysqlQuery = $db->prepare('UPDATE kategorie SET name=:name, img = :img WHERE id = :id');
	}
	else{
		$mysqlQuery = $db->prepare('UPDATE kategorie SET name=:name, img = :img, img2 = :img2 WHERE id = :id');
		$mysqlQuery->bindValue(':img2', $img2, PDO::PARAM_STR);
	}
	if(is_uploaded_file($tmp_nazwa))
	{ 
		if(move_uploaded_file($tmp_nazwa , "../$img2"))
		{
		}else{
			$ok = 2;
		}
	}else{
		$ok = 2;
	}
	
	$mysqlQuery->bindValue(':name', $name_cat, PDO::PARAM_STR);
	$mysqlQuery->bindValue(':img', $img1, PDO::PARAM_STR);
	$mysqlQuery->bindValue(':id', $id, PDO::PARAM_STR);
	$mysqlQuery->execute();
	
}


$rezultat= $polaczenie->query("SELECT * FROM `kategorie` WHERE `id` = '$id'");
while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
		
	$name = $wiersz['name'];
	$img = $wiersz['img'];
	$img2 = $wiersz['img2'];
		
}

if(isset($_GET['del'])){
	$del = $_GET['del'];
	
	$rezultat = $polaczenie->query("SELECT * FROM `slowa` WHERE `id` = '$del'");
	$istnieje = $rezultat->num_rows;
	
	if($istnieje == 1){
		if($polaczenie->query("DELETE FROM `slowa` WHERE `id` = '$del'")){
			$delete = true;
			
		}
	}
	
}



if(isset($_POST['slowo'])){
	
	$slowo_post = $_POST['slowo'];
	$nazwy = explode(", ", $slowo_post);
	$ilosc_nazw = count($nazwy);
	
	for($i=0;$i<$ilosc_nazw;$i++){
		$slowa_do_bazy = $nazwy[$i];
		$polaczenie->query("INSERT INTO `slowa` VALUES(NULL, '$slowa_do_bazy', $id)");
	}
	
	$wstawiono = $ilosc_nazw;
	
	
}
	

		
		
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require("components/header.php") ?>
</head>
<body>

<?php require("components/nav.php")  ?> 

  <div id="content">
  
	
	<?php

		if(!empty($wstawiono)){
			
		?>
			<div class="alert alert-success" role="alert">
  Pomyślnie dodano <?php echo $wstawiono ?> słów do tej kategorii.
</div>
			<?php
		}

	?>
	
	<?php

		if(isset($delete)){
			
		?>
			<div class="alert alert-success" role="alert">
  Pomyślnie usunięto to słowo.
</div>
			<?php
		}

	?>
	
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Kategoria <?php echo $name ?></h5>
			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
				<label for="nazwakategorii">Nazwa kategorii</label>
				<input type="text" class="form-control" name="nazwakategorii" id="nazwakategorii" aria-describedby="emailHelp" value="<?php echo $name; ?>" placeholder="Nazwa kategorii">
			  </div>
			  <div class="form-group">
				<label for="imgkategorii">Ikonka</label>
				<input type="text" class="form-control" name="imgkategorii" id="imgkategorii" aria-describedby="emailHelp" value="<?php echo htmlspecialchars($img, ENT_QUOTES); ?>" placeholder="Obrazek kategorii">
				<small id="exampleFormControlTextarea23" class="form-text text-muted">Ze strony <a href="https://fontawesome.com/" target="_blank">https://fontawesome.com/</a></small>
			  </div>
			  <div class="custom-file" style="margin-bottom:20px;">
							  <input type="file" name="plik" class="custom-file-input" id="customFile">
							  <label class="custom-file-label" for="customFile">Wybierz plik</label>
							</div>
				<input type="submit" value="Edytuj"  class="btn btn-primary"/>
				<center><h4>Aktualne zdjęcie</h4>
				<img src="../<?php echo $img2 ?>" class="img-thumbnail" style="max-width:200px;"/></center>
			</form>
		</div>
	</div>
	
	
	<div class="card" style="margin-top:30px;">
		<div class="card-body">
			<h5 class="card-title">Dodaj slowo do kategorii</h5>
			<form method="post">
				<div class="form-group">
					<label for="exampleFormControlTextarea1">Słowa kluczowe kategorii</label>
					<textarea class="form-control" name="slowo" id="exampleFormControlTextarea1" rows="5"></textarea>
					<small id="exampleFormControlTextarea" class="form-text text-muted">Muszą być oddzielone przecinkami i spacją : np . Dom, Domek</small>
				</div>
				<input type="submit" value="Dodaj"  class="btn btn-primary"/>
			</form>
		</div>
	</div>

<div class="card" style="margin-top:30px;">
		<div class="card-body">
			<h5 class="card-title">Kategorie</h5>
				<table class="table">
					<thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">Nazwa</th>
						  <th scope="col">Akcje</th>
						</tr>
					</thead>
					<tbody>
<?php
$rezultat= $polaczenie->query("SELECT * FROM `slowa` WHERE `id_kategoria` = '$id'");
while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
		
	$name = $wiersz['slowo'];
	$id1 = $wiersz['id'];
	
?>

						<tr>
							<td scope="row"><?php echo $id1 ?></td>
							<td><?php echo $name ?></td>
							<td><a href="kategoria.php?id=<?php echo $id ?>&del=<?php echo $wiersz['id'] ?>"><button type="button" class="btn btn-danger">Usuń</button></a></td>
						
						</tr>


<?php


}
?>
					</tbody>
				</table>
				
				
				
</div></div>
	<?php require("components/footer.php") ?>
	<script>
	$( "#customFile" ).change(function() {
		$(".custom-file-label").text("Wybrano plik");
	});
	</script>
</body>
</html>