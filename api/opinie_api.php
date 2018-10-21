<?php 


if(isset($_GET['get'])){
	$api_id = $_GET['id'];
	require_once("connect.php");
	require_once("../inc/class_organizacja.php");
	$i=0;
	$rezultat= $polaczenie->query("SELECT * FROM `opinie` WHERE `firma_id` = '$api_id' ORDER BY `id` DESC");
	$num_opini = $rezultat->num_rows;
	if($num_opini > 0){
		while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
			$imie = $wiersz['imie'];
			$opinia = $wiersz['opinia'];
			$data = $wiersz['data'];
			$id_op = $wiersz['id'];
			$opinia_number = $wiersz['opinia_number'];
			
			$tablica_json[$i]['imie'] = $imie;
			$tablica_json[$i]['opinia'] = $opinia;
			$tablica_json[$i]['data'] = $data;
			$tablica_json[$i]['id_op'] = $id_op;
			$tablica_json[$i]['opinia_number'] = $opinia_number;
			$i++;
		}

	echo json_encode($tablica_json);
	}
}

if(isset($_GET['srednia'])){
	require_once("connect.php");
	$api_id = $_GET['id'];
	$opinie_all = 0;
	$rezultat= $polaczenie->query("SELECT * FROM `opinie` WHERE `firma_id` = '$api_id'");
	$liczba_opinii = $rezultat->num_rows;
	if($liczba_opinii > 0){
		while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){		
			$opinie_all  = $opinie_all +  $wiersz['opinia_number'];	
		}	
		echo $wynik = round($opinie_all/$liczba_opinii , 1);
	}else{
		echo $wynik = 0.0001;
	}  
}


if(isset($_GET['add'])){
	require_once("connect.php");
	$imie = urldecode($_GET['a']);
	$opinia = urldecode($_GET['b']);
	$opinia_number = $_GET['c'];
	$date = date('Y-m-d H:i:s');
	$id = $_GET['d'];
	
	if($polaczenie->query("INSERT INTO `opinie` VALUES(NULL, '$imie', '$opinia', '$id', '$date', '$opinia_number')")){
		echo "Opinia dodana";
	}else{
		echo "Cos poszlo nie tak:/";
	}
}







?>