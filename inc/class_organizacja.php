<?php 


class organizacja{
	
	public $connect;
	public $id;
	
	public $krs;
	public $nip;
	public $nazwa;
	public $wojewodztwo;
	public $powiat;
	public $gmina;
	public $miasto;
	public $stan_konta;
	
	public $cel_dzialania;
	public $regon;
	public $kod_pocztowy;
	public $pelny_adres;
	public $ulica;
	public $numer_lokalu;
	public $data_powstania;
	public $email;
	
	public $kategoria;
	public $kategoria_link;
	
	public $category_img;
	
	
	public function __construct($id = null){
		require("connect.php");
		$this->connect = $db;
		$this->id = $id;
		$fail_search = "Nie znaleziono takiego rekordu w bazie.";
		
	
		if(is_numeric($id)){
			/* WYCIAGANIE WSZYSTKIEGO OPROCZ STANU KONTA - baza 'dane_firmy' */
			$mysqlQuery = $this->connect->prepare('SELECT * FROM dane_firmy WHERE id=:id');
			$mysqlQuery->bindValue(':id', $this->id, PDO::PARAM_STR);
			$mysqlQuery->execute();
			$organizacja = $mysqlQuery->fetch();
			if($organizacja['id'] == NULL)
			{
				$this->krs = $fail_search;
				$this->nip= $fail_search;
				$this->nazwa= $fail_search;
				$this->wojewodztwo= $fail_search;
				$this->powiat= $fail_search;
				$this->gmina= $fail_search;
				$this->miasto= $fail_search;
			}
			else 
			{
				$this->krs = $organizacja['NRKR'];
				$this->nip= $organizacja['NUMER_NIP'];
				$this->nazwa= $organizacja['NAZWA'];
				$this->wojewodztwo= $organizacja['WOJEWODZTWO'];
				$this->powiat= $organizacja['POWIAT'];
				$this->gmina= $organizacja['GMINA'];
				$this->miasto= $organizacja['MIEJSCOWOSC'];
				
				
				$this->cel_dzialania = $organizacja['CEL_DZIALANIA'];
				$this->regon = $organizacja['REGON'];
				$this->pelny_adres = $organizacja['ADRES'];
				$this->kod_pocztowy= $organizacja['KOD_POCZTOWY'];
				$this->ulica= $organizacja['ULICA'];
				$this->numer_lokalu= $organizacja['NUMER_LOKALU'];
				$this->data_powstania = $organizacja['DATA_POWSTANIA'];
				$this->email = $organizacja['EMAIL'];
				//$this->stan_konta= $organizacja[''];
							
			}
			
			
			/* WYCIAGANIE STANU KONTA - baza 'money' */
			$mysqlQuery = $this->connect->prepare('SELECT * FROM money WHERE NumerKRS=:id');
			$mysqlQuery->bindValue(':id', $this->krs, PDO::PARAM_STR);
			$mysqlQuery->execute();
			$money = $mysqlQuery->fetch();
			if($organizacja['id'] == NULL)
			{
				$fail_search = "Nie znaleziono takiego rekordu w bazie.";
				$this->stan_konta = $fail_search;
			}
			else 
			{
				$this->stan_konta= $money['Kwota'];		
			}
		}
		
		
		$rezultat = $polaczenie->query("SELECT * FROM `kategorie_relacje` WHERE `firma_id` = '$id'");
		$i = 0;
		while ($wiersz = mysqli_fetch_array($rezultat, MYSQLI_ASSOC)) {
			
			$category_id = $wiersz['category_id'];
			
			$mysqlQuery = $this->connect->prepare('SELECT * FROM `kategorie` WHERE `id`=:id');
			$mysqlQuery->bindValue(':id', $category_id, PDO::PARAM_STR);
			$mysqlQuery->execute();
			$category = $mysqlQuery->fetch();
			
			$cat_name = $category['name'];
			$cat_id = $category['id'];
			
			if($i==0){
				$kategoria_array[] = $cat_name;
				$first_cat = $cat_id;
				$kategoria_array_link[] = '<a href="search.php?category='.$cat_id.'">'.$cat_name.'</a>';
				
			}else{
			
				if(!in_array($cat_name,$kategoria_array)){
					
					$kategoria_array_link[] = '<a href="search.php?category='.$cat_id.'">'.$cat_name.'</a>';
					$kategoria_array[] = $cat_name;
					
					
				}
			}
			
			$i++;
			
		}
		if(!empty($kategoria_array)){
			$this->kategoria = implode(" / ", $kategoria_array);
		}else{
			$this->kategoria = "Brak danych";
		}
		
		if(!empty($kategoria_array_link)){
			$this->kategoria_link = implode(" / ", $kategoria_array_link);
		}else{
			$this->kategoria_link = "Brak danych";
		}
		
		
		
		$mysqlQuery = $this->connect->prepare('SELECT * FROM `kategorie` WHERE `id` = :kategoria_id');
		$mysqlQuery->bindValue(':kategoria_id', $first_cat, PDO::PARAM_STR);
		$mysqlQuery->execute();
		$slowoMySql = $mysqlQuery->fetch();
					if($slowoMySql['img2'] == "brak" OR $slowoMySql['img2'] == "Brak danych"){
						$this->category_img = "img/placeholder.png";
					}else{
		$this->category_img =  $slowoMySql['img2'];
					}
	}
		
}
	
	
	
	
	
	

