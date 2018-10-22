<?php 

require("connect.php");

function count_category($id, $miejscowosc, $nazwa){
	
	if($id == 1){

		$rezultat = $polaczenie->query("SELECT DISTINCT `firma_id` FROM `kategorie_relacje`");
		while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) {
			
			$all_cat[] = $wiersz['firma_id'];
		}
	
		if(empty($miejscowosc)){
			$allcat = implode(",", $all_cat);
			$nazwa_to_sql = '%'.$nazwa.'%';
			$miejscowosc_to_sql = '%'.$miejscowosc.'%';
			$rezultat1= $polaczenie->query("SELECT * FROM `dane_firmy` WHERE `NAZWA` LIKE '$nazwa_to_sql'  AND `id` IN ($allcat)");
			$num_rows = $rezultat1->num_rows;
		}
		else{
			$allcat = implode(",", $all_cat);
			$nazwa_to_sql = '%'.$nazwa.'%';
			$miejscowosc_to_sql = '%'.$miejscowosc.'%';
			$rezultat1= $polaczenie->query("SELECT * FROM `dane_firmy` WHERE `MIEJSCOWOSC` = '$miejscowosc' AND  `NAZWA` LIKE '$nazwa_to_sql'  AND `id` IN ($allcat)");
			$num_rows = $rezultat1->num_rows;
		}
		
		
	}else{				
		$rezultat = $polaczenie->query("SELECT DISTINCT `firma_id` FROM `kategorie_relacje` WHERE `category_id` = '$id'");
		while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) {
			
			$all_cat[] = $wiersz['firma_id'];
		}
	
		if(empty($miejscowosc)){
			$allcat = implode(",", $all_cat);
			$nazwa_to_sql = '%'.$nazwa.'%';
			$miejscowosc_to_sql = '%'.$miejscowosc.'%';
			$rezultat1= $polaczenie->query("SELECT * FROM `dane_firmy` WHERE `NAZWA` LIKE '$nazwa_to_sql'  AND `id` IN ($allcat)");
			$num_rows = $rezultat1->num_rows;
		}
		else{
			$allcat = implode(",", $all_cat);
			$nazwa_to_sql = '%'.$nazwa.'%';
			$miejscowosc_to_sql = '%'.$miejscowosc.'%';
			$rezultat1= $polaczenie->query("SELECT * FROM `dane_firmy` WHERE `MIEJSCOWOSC` = '$miejscowosc' AND  `NAZWA` LIKE '$nazwa_to_sql'  AND `id` IN ($allcat)");
			$num_rows = $rezultat1->num_rows;
		}
	}
	return $num_rows;
}

if(isset($_GET['empty_city'])){
	$city = $_GET['city'];
	$rezultat = $polaczenie->query("SELECT DISTINCT(id) FROM `dane_firmy` WHERE `MIEJSCOWOSC` = '$city'");
	if($rezultat->num_rows>0){
		while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
			$id_from_city[] =  $wiersz['id'];	
		}
	}
	echo json_encode($id_from_city);
}


if(isset($_GET['empty_nazwa'])){
	$nazwa = $_GET['nazwa'];
	$nazwa_to_sql = '%'.$nazwa.'%';
	$rezultat = $polaczenie->query("SELECT DISTINCT(id) FROM `dane_firmy` WHERE `NAZWA` LIKE '$nazwa_to_sql'");
	if($rezultat->num_rows>0){
		while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
			$id_from_name[] =  $wiersz['id'];	
		}
	}	
	echo json_encode($id_from_name);
}


if(isset($_GET['empty_category'])){
	$category = $_GET['category'];
	if($category != 1){
		$mysqlQuery = $db->prepare('SELECT DISTINCT(firma_id) FROM `kategorie_relacje` WHERE `category_id` = :category');
		$mysqlQuery->bindValue(':category', $category, PDO::PARAM_STR);
		$mysqlQuery->execute();
		$kategorie_from_mysql = $mysqlQuery->fetchAll();	
		foreach($kategorie_from_mysql as $row) {
			$id_from_category[] =  $row['firma_id'];
		}
	}else{
		$mysqlQuery = $db->prepare('SELECT DISTINCT(firma_id) FROM kategorie_relacje');
		$mysqlQuery->execute();
		$kategorie_from_mysql = $mysqlQuery->fetchAll();	
		foreach($kategorie_from_mysql as $row) {
			$id_from_category[] =  $row['firma_id'];
		}
	}
	echo json_encode($id_from_category);
}


if(isset($_POST['get_items'])){
	
	$implode_result = $_POST['implode'];
	$rezultat= $polaczenie->query("SELECT * FROM `dane_firmy` WHERE `id` IN ($implode_result)");
	if($rezultat->num_rows >0){
		while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
		$id[] = $wiersz['id'];
		
		}
	}
	
	echo json_encode($id);
}



if(isset($_GET['get_category'])){
	
	$city = $_GET['city'];
	$nazwa = $_GET['nazwa'];
	
	$i=0;
	$rezultat = $polaczenie->query("SELECT * FROM `kategorie`");
	while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) 
	{
		$cat_name = $wiersz['name'];
		$cat_id = $wiersz['id'];
		$cat_img = $wiersz['img'];
						
		if(empty($_GET['city']) AND !empty($_GET['get_category']) AND empty($_GET['nazwa'])){
			$rezultat2 = $polaczenie->query("SELECT DISTINCT `firma_id` FROM `kategorie_relacje` WHERE `category_id` = '$cat_id'");
			$liczba_kat[$i] = $rezultat2->num_rows;
		}else{
			$city = $_GET['city'];
			$nazwa = $_GET['nazwa'];
			$liczba_kat[$i] = count_category($cat_id, $city, $nazwa);			
		}
						
		if($liczba_kat[$i] != 0){
			?>
			<li <?php if($cat_id == $_GET['get_category']) {   echo 'class="active"';      } ?>><a href="search.php?category=<?php echo $cat_id ?><?php if(isset($_GET['nazwa'])) echo '&nazwa='.$_GET['nazwa']; ?><?php if(isset($_GET['city'])) echo '&city='.$_GET['city']; ?>"><?php echo $cat_img ?><?php echo $cat_name; ?> <?php if(!empty($liczba_kat)) echo '('.$liczba_kat[$i].')'; ?></a></li>
					
			<?php 
		}
		
		$i++;
	}
}





if(isset($_GET['get_category_one'])){
	$city = $_GET['city'];
	$nazwa = $_GET['nazwa'];
	
	?><li <?php if(isset($_GET['get_category_one'])) {  if(1 == $_GET['get_category_one']) {   echo 'class="active"';    }  } ?>><a href="search.php?category=1<?php if(isset($_GET['nazwa'])) echo '&nazwa='.$_GET['nazwa']; ?><?php if(isset($_GET['city'])) echo '&city='.$_GET['city']; ?>">Wszystkie (<?php echo count_category(1, $city, $nazwa) ?>)</a></li><?php
	
	
	
}



?>