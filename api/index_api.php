<?php
require_once("connect.php");

if(isset($_GET["get_all_city"])){
	
		$i = 0;
		$rezultat = $polaczenie->query("SELECT DISTINCT `MIEJSCOWOSC` FROM `dane_firmy`");
		while ($wiersz2= mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) 
		{
			$miasto = mb_strtolower($wiersz2['MIEJSCOWOSC'], 'UTF-8');

			if($i==0){
				
				?> '<?php echo ucwords($miasto) ?>'<?php
				
			}else{
			
			
			
			?>,'<?php echo ucwords($miasto) ?>'<?php
			}
			$i++;
}
}

