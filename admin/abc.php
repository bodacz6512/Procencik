<?php 
echo "START<br>";
$i=0;
require("connect.php");
$rezultat = $polaczenie->query("SELECT * FROM `money`");
$num_rows = $rezultat->num_rows;
while($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)){
	
	$krs = $wiersz['NumerKRS'];
	$stan_konta = $wiersz['Kwota'];
	
	if($polaczenie->query("UPDATE `dane_firmy` SET `STAN_KONTA` = '$stan_konta' WHERE `NRKR` = '$krs'")){
		$i++;
	}
	
}

echo "Wykonano poprawnie $i/$num_rows wpisów do bazy";
echo "XD";

?>