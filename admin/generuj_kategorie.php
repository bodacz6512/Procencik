<?php 
session_start();


require_once("connect.php");
require_once("../inc/class_organizacja.php");

$polaczenie->query("DELETE FROM `kategorie_relacje`");

// pobieranie slow
$mysqlQuery = $db->prepare('SELECT * FROM `slowa`');
$mysqlQuery->execute();
$slowa_kategorii = $mysqlQuery->fetchAll();	
foreach($slowa_kategorii as $row) {
	$content[] = mb_strtolower($row['slowo'], "UTF-8");
}	
$liczba_slow = count($content);
// koniec pobierania slow

$k=0;
$rezultat = $polaczenie->query("SELECT * FROM `dane_firmy`");
$rezultat23 = $polaczenie->query("SELECT * FROM `dane_firmy`");
$num_rows = $rezultat23->num_rows;
while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) 
{
	$id = $wiersz['id'];	
	$nazwa = $wiersz['NAZWA'];	
	$cel_dzialania = $wiersz['CEL_DZIALANIA'];	
	$nip = $wiersz['NUMER_NIP'];	
	$all_text = mb_strtolower($cel_dzialania.' '.$nazwa.' '.$nip, "UTF-8");
	$tekst_do_szukania = explode(" ", $all_text);
	
	
	
	$wynik = array_intersect($content, $tekst_do_szukania);
	$i=0;
	foreach($wynik as $slowo_k => $val){
		$mysqlQuery = $db->prepare('SELECT * FROM `slowa` WHERE `slowo` = :slowo');
		$mysqlQuery->bindValue(':slowo', $val, PDO::PARAM_STR);
		$mysqlQuery->execute();
		$slowoMySql = $mysqlQuery->fetch();
					
		$categ_id = $slowoMySql['id_kategoria'];
		$i++;
		
		$polaczenie->query("INSERT INTO `kategorie_relacje` VALUES(NULL, '$categ_id', '$id')");
			
	}
			/*
		
	if($i != 0){
	
		$all_id_cat[$id] = array_unique($all_id_cat[$id]);
		$all_imp_id_cat = implode(" / ", $all_id_cat[$id]);
		
	}else{
		$all_imp_id_cat = "0";
	}
	
	
	echo $all_imp_id_cat;
	echo "<br>";
	
	*/
	
	
	$k++;
	
	
}

if($k+1 > $num_rows){
	echo $i*$k;
}





?>