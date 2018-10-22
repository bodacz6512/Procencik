<?php 

if(isset($_GET['city'])){
	$city = $_GET['city'];
}
if(isset($_GET['category'])){
	$category = $_GET['category'];
}
if(isset($_GET['nazwa'])){
	$nazwa = $_GET['nazwa'];
}

$show_per_page = 20;

if(!isset($_GET['page'])){
	$page = 1;
}else{
	$page = $_GET['page'];
}

if($page == 1){
	$offset = 0;
}else{
	$offset = (($page -1) * $show_per_page) ;
}
$offset_show = $offset+1;

$show_per_page_x_page = $show_per_page * $page;



// POBRANIE WSZYSTKICH FIRM DLA MIASTA, KATEGORII I NAZWY //

	
	if(!empty($city)){
		$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?empty_city&city=$city");
		$id_from_city  = json_decode($content);
	}
	
	if(!empty($nazwa)){
		$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?empty_nazwa&nazwa=$nazwa");
		$id_from_name  = json_decode($content);	
	}
	
	if(!empty($category)){
		$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?empty_category&category=$category");
		$id_from_category  = json_decode($content);	
	}
	

	
	
	
	
	// WSZYSTKIE
	if(!empty($city) AND !empty($category) AND !empty($nazwa)){
		$array1 = array_intersect($id_from_city, $id_from_category);
		$array2 = array_intersect($id_from_city, $id_from_name);
		$array3 = array_intersect($id_from_category, $id_from_name);
		$data = array($array1, $array2, $array3);
		$result = call_user_func_array('array_intersect', $data);
	}
/*MIASTO / KATEGORIA */ if(!empty($city) AND !empty($category) AND empty($nazwa)){ $result = array_intersect($id_from_city, $id_from_category); }

/*MIASTO / NAZWA */ if(!empty($city) AND empty($category) AND !empty($nazwa)){  $result = array_intersect($id_from_city, $id_from_name); }

/*KATEGORIA / NAZWA */ if(empty($city) AND !empty($category) AND !empty($nazwa)){ $result = array_intersect($id_from_name, $id_from_category); }

/*MIASTO */ if(!empty($city) AND empty($category) AND empty($nazwa)){ $result = $id_from_city; }
/*NAZWA */ if(empty($city) AND empty($category) AND !empty($nazwa)){ $result = $id_from_name; }
/*KATEGORIA */ if(empty($city) AND !empty($category) AND empty($nazwa)){ $result = $id_from_category; }

	
	
	
	
	
	
	
	
// END POBRANIE WSZYSTKICH FIRM DLA MIASTA ,KATEGORII I NAZWY //





// ZMIANA WYNIKU NA STRINGA ŻEBY UMIEŚCIC GO W FUNKCJI IN W MYSQL //
if(!empty($result)){
	$result = array_values($result);
	for($i=$offset;$i<$show_per_page_x_page;$i++){
		if(!empty($result[$i])){
			$result_fixed[] = $result[$i];
		}
	}
	
	$implode_result = implode(",", $result_fixed);
}


// END ZMIANA WYNIKU NA STRINGA ŻEBY UMIEŚCIC GO W FUNKCJI IN W MYSQL  //



?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<title>Wyszukiwanie organizacji</title>
	<style>
	
	.search-title{
		text-transform:lowercase;
	}
	
	.search-title:first-letter{
		text-transform:uppercase;
	}
	
	</style>
</head>
<body>


	<?php require("components/nav.php") ?>
	
	<div class="heart-container"><div class="lds-heart"><div></div></div></div>
	
	<div class="content" style="display:none;">
	
		<div class="search-container">
				
			<div class="categories-search">
			
				<form method="get">
				<h3>Nazwa</h3>
					<input type="text" name="nazwa" value="<?php if(isset($_GET['nazwa'])){ echo $_GET['nazwa'];  } ?>">
					<?php if(!empty($category))  { ?> <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>"> <?php } ?>
					<h3>Miasto</h3>
					<input type="text" name="city" value="<?php if(isset($_GET['city'])){ echo $_GET['city']; } ?>">
					<div class="text-align-right"><input type="submit" value="Wyszukaj"/></div>
				
				</form>
			
				<h3>Kategorie</h3>
				<ul>
					
					<?php 
				if(isset($_GET['city'])){
					$city = $_GET['city'];
				}else{
					$city = "";
				}
				if(isset($_GET['category'])){
					$cat = $_GET['category'];
				}else{
					$cat = "";
				}
				if(isset($_GET['nazwa'])){
					$nazwa = $_GET['nazwa'];
				}else{
					$nazwa = "";
				}
				
				
					
						echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?get_category_one=$cat&nazwa=$nazwa&city=$city");
				
					if(!empty($_GET['city'])){
						echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?get_category=$cat&city=$city");
					}
					else if(!empty($_GET['nazwa'])){
						echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?get_category=$cat&nazwa=$nazwa");
					}
					else if(!empty($_GET['nazwa']) AND !empty($_GET['city'])){
						echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?get_category=$cat&nazwa=$nazwa&city=$city");
					}else{
						echo $content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/search_api.php?get_category=$cat");
					}
					?>
				</ul>
			</div>
			
			
		
			<div class="content-search">
				<div class="arrows-pagination mobile">
					<div class="arrow-paginate">
									<a href="#" onclick="filtr()"><i class="fas fa-filter"></i>Filtrowanie</a>
					</div>
				</div>
				<div class="overlay-filtr-mobile" onclick="filtr()" style="display:none;"></div>
			
				<div class="results-finally" >
					<h3 class="search-title">Wyniki wyszukiwania</h3>
					<p>Pokazywanie  <?php echo $offset+1 ?> - <?php  if(count($result) < $show_per_page_x_page) {echo count($result);} else { echo $show_per_page_x_page; $last_page = 1; } ?> z <?php echo count($result); ?> wszystkich znalezionych fundacji.</p>
					
					<div class="arrows-pagination">
					<?php if($offset != 0){ ?>
						<a href="?page=<?php echo $page-1;

							if(isset($_GET['category'])){
								echo "&category=".$_GET['category'];
							}
							
							if(isset($_GET['nazwa'])){
								echo "&nazwa=".$_GET['nazwa'];
							}
							
							if(isset($_GET['city'])){
								echo "&city=".$_GET['city'];
							}


							?>"><div class="arrow-paginate"><i class="fas fa-arrow-circle-left"></i>Poprzednia strona
						</div></a>
						<?php } ?>
						<?php if(isset($last_page)){ if($last_page ==1){ ?>
						<a href="?page=<?php echo $page+1;

							if(isset($_GET['category'])){
								echo "&category=".$_GET['category'];
							}
							
							if(isset($_GET['nazwa'])){
								echo "&nazwa=".$_GET['nazwa'];
							}
							
							if(isset($_GET['city'])){
								echo "&city=".$_GET['city'];
							}


							?>"><div class="arrow-paginate">
							<i class="fas fa-arrow-circle-right"></i>Następna strona
						</div></a>
					
						<?php } } ?>
						</div>
							<div class="search-flex">
						<?php 
						
						$url = 'http://serwer1869889.home.pl/projekt/api/search_api.php';
						$context = stream_context_create(array(
							'http' => array(
								'method' => 'POST',
								'header' => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query(
									array(
										'implode' => $implode_result,
										'get_items' => 1
									)
								),
								'timeout' => 360
							)
						));

						$resp = file_get_contents($url, FALSE, $context);
						$json_res = json_decode($resp);
						$count_json_rest = count($json_res);
						for($i=0;$i<$count_json_rest;$i++){
							$content =  file_get_contents("http://serwer1869889.home.pl/projekt/api/get_item_api.php?id=$json_res[$i]");
							$result  = json_decode($content);
						
					
						?>
				

								<div class="search-item">
									<div class="search-item-img">
										<a href="item.php?id=<?php echo $json_res[$i]; ?>"><img src="<?php echo $result->category_img; ?>" /></a>
									</div>
									<div class="search-item-desc">
										<a href="item.php?id=<?php echo $json_res[$i]; ?>"><h4><?php echo $result->nazwa; ?></h4>
										<h5>Kategoria : <?php echo $result->kategoria_link; ?></h5>
									</div>
								</div>

							<?php 
						}
							/*
							}
					}else{
						echo $implode_result;
						echo "<br><p>Nie znaleziono tego czego szukasz :(</p>";
					}*/
					?>
					</div>
					
					<div class="arrows-pagination">
					<?php if($offset != 0){ ?>
						<a href="?page=<?php echo $page-1;

							if(isset($_GET['category'])){
								echo "&category=".$_GET['category'];
							}
							
							if(isset($_GET['nazwa'])){
								echo "&nazwa=".$_GET['nazwa'];
							}
							
							if(isset($_GET['city'])){
								echo "&city=".$_GET['city'];
							}


							?>"><div class="arrow-paginate"><i class="fas fa-arrow-circle-left"></i>Poprzednia strona
						</div></a>
						<?php } ?>
						<?php if(isset($last_page)){ if($last_page ==1){ ?>
						<a href="?page=<?php echo $page+1;

							if(isset($_GET['category'])){
								echo "&category=".$_GET['category'];
							}
							
							if(isset($_GET['nazwa'])){
								echo "&nazwa=".$_GET['nazwa'];
							}
							
							if(isset($_GET['city'])){
								echo "&city=".$_GET['city'];
							}


							?>"><div class="arrow-paginate">
							<i class="fas fa-arrow-circle-right"></i>Następna strona
						</div></a>
					
						<?php } } ?>
						</div>
				</div>
			
			</div>
		</div>
	</div>
	
	
	

	

	<?php require_once("components/footer.php") ?>
	<script>
	
		$(document).ready(function() {

			$(".heart-container").addClass("animated fadeOut");
			$(".heart-container").css("display", "none");
			$(".content").css("display", "block");
			$(".content").addClass("animated fadeIn");
				

		});

		
	
	</script>
</body>
</html>