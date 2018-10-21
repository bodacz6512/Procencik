<?php 

session_start();
require("connect.php");
if(!isset($_SESSION['logged'])){
	
	header("Location: login.php");
	exit;
}


if(isset($_POST['nazwa_kategoria'])){
	$nazwa = $_POST['nazwa_kategoria'];
	$polaczenie->query("INSERT INTO `kategorie` VALUES(NULL, '$nazwa', 'brak', 'brak')");
	$dodano = true;
}

if(isset($_GET['del'])){
	$del = $_GET['del'];
	
	$rezultat = $polaczenie->query("SELECT * FROM `kategorie` WHERE `id` = '$del'");
	$istnieje = $rezultat->num_rows;
	
	if($istnieje == 1){
		if($polaczenie->query("DELETE FROM `kategorie` WHERE `id` = '$del'")){
			$delete = true;
			
		}
	}
}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require("components/header.php") ?>
	
	<style>
	table i{
		font-size:40px;
	}
	</style>
</head>
<body>


<?php require("components/nav.php")  ?> 

  <div id="content">

  <?php 
  
  if(isset($delete)){
	  ?>
	  <div class="alert alert-success" role="alert">
	  Pomyślnie usunięto kategorię.
</div>
	  <?php
	  
  }
  
  ?>
  
  <?php 
  
  if(isset($dodano)){
	  ?>
	  <div class="alert alert-success" role="alert">
	  Pomyślnie dodano kategorię.
</div>
	  <?php
	  
  }
  
  ?>
  
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">Dodawanie nowej kategorii</h5>
			<form method="post">
				<div class="form-group">
					<label for="nazwa">Nazwa kategorii</label>
					<input type="text" name="nazwa_kategoria"  class="form-control" id="nazwa" aria-describedby="nazwa_kategoria" placeholder="Wprowadź nazwę kategorii">
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
						  <th scope="col">Ikonka</th>
						  <th scope="col">Akcje</th>
						</tr>
					</thead>
					<tbody>
	<?php
	$rezultat= $polaczenie->query("SELECT * FROM `kategorie`");
	while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
		
	?>
						<tr>
							<th scope="row"><?php echo $wiersz['id'] ?></th>
							<td><?php echo $wiersz['name'] ?></td>
							<td><?php echo $wiersz['img'] ?></td>
							<td>
								<a href="kategoria.php?id=<?php echo $wiersz['id'] ?>"><button type="button" class="btn btn-primary">Edytuj</button></a>
								<a href="?del=<?php echo $wiersz['id'] ?>"><button type="button" style="margin-left:25px;" class="btn btn-danger">Usuń</button></a>
							</td>
						</tr>
	<?php
	}
	
	?>
					</tbody>
				</table>

		</div>
	</div>



	
	
	
	
	</div>
</div>	

	<?php require("components/footer.php") ?>
</body>
</html>


