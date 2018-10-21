<?php

require_once("connect.php");

if(!empty($_GET['get_all_money_org']))
{
	$rezultat = $polaczenie->query("SELECT SUM(Kwota) as TOTAL from `money`");
	while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) 
	{
		$total= $wiersz['TOTAL'];
	}

	$rezultat = $polaczenie->query("SELECT * from `money`");
	$liczba_fundacji = $rezultat->num_rows;
	
	$tablica_json['total'] = $total;
	$tablica_json['liczba_fundacji'] = $liczba_fundacji;
	
	
	echo json_encode($tablica_json);
}



if(isset($_GET['get_money'])){
	$i=0;
	$count = $_GET['count'];
	$offset = $_GET['offset'];
		$rezultat1 = $polaczenie->query("SELECT * FROM `dane_firmy` ORDER BY `STAN_KONTA`DESC LIMIT $count OFFSET $offset");
		while ($wiersz2= mysqli_fetch_array($rezultat1, MYSQLI_ASSOC)) 
		{
			$id = $wiersz2['id'];
			$nazwa = $wiersz2['NAZWA'];
			$stan_konta = $wiersz2['STAN_KONTA'];
			$money[$i]['nazwa']	= $nazwa;
			$money[$i]['id']	= $id;
			$money[$i]['stan_konta']	= $stan_konta;
			
			if($_GET['get_money'] == "category")
			{
				$rezultat = $polaczenie->query("SELECT DISTINCT `category_id` FROM `kategorie_relacje` WHERE `firma_id` = '$id'");
				while ($wiersz= mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) 
				{
					$category_id = $wiersz['category_id'];
					$rezultat5 = $polaczenie->query("SELECT name FROM `kategorie` WHERE `id` = $category_id");
					while ($wiersz3= mysqli_fetch_array($rezultat5, MYSQLI_ASSOC)) 
					{
						$categories[$i][] = '<a href="search.php?category='.$category_id.'">'.$wiersz3['name'].'</a>';
					}
					$categories_imp = implode(" / ", array_unique($categories[$i]));

						$money[$i]['categories']	= $categories_imp;
				}
				
			}
			
			
			
			
			
			$i++;
		}
		
	echo json_encode($money);
}