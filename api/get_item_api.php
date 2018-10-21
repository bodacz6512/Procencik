<?php 


$api_id = $_GET['id'];
require_once("connect.php");
require_once("../inc/class_organizacja.php");


$organizacja = new organizacja($api_id);
$tablica_json = array(
	'nazwa' => $organizacja->nazwa, 
	'stan_konta' => $organizacja->stan_konta,
	'krs' =>  $organizacja->krs,
	'nip' =>  $organizacja->nip,
	'wojewodztwo' =>  $organizacja->wojewodztwo,
	'powiat' =>  $organizacja->powiat,
	'gmina' =>  $organizacja->gmina,
	'miasto' =>  $organizacja->miasto,
	
	'cel_dzialania' =>  $organizacja->cel_dzialania,
	'regon' =>  $organizacja->regon,
	'kod_pocztowy' =>  $organizacja->kod_pocztowy,
	'pelny_adres' =>  $organizacja->pelny_adres,
	'ulica' =>  $organizacja->ulica,
	'numer_lokalu' =>  $organizacja->numer_lokalu,
	'data_powstania' =>  $organizacja->data_powstania,
	'email' =>  $organizacja->email,
	
	'kategoria' =>  $organizacja->kategoria,
	'kategoria_link' =>  $organizacja->kategoria_link,
	
	'category_img' =>  $organizacja->category_img,



);

echo json_encode($tablica_json);




?>