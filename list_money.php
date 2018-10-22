<?php 

$per_page = 20;

if(!empty($_GET['page'])){
	$page = $_GET['page'];
}else{
	$page = 1;
}


if($page == 1){
	$beforepage = 0;
	$limit = 20;
	$offset = 0;
}else{
	$offset = $per_page * ($page - 1);
	$limit = 20;
}


?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require_once("components/header.php") ?>
	<link rel="stylesheet" href="css/list.css?<?php echo time() ?>" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/fontawesome-stars.css" />
	<link rel="stylesheet" href="css/fontawesome-stars-o.css" />
	<title>Lista dochodów fundacji | Procencik</title>

</head>
<body>


	<?php require("components/nav.php") ?>
	
	
	
	<div class="list-container">
	
	
	<?php
	$content = file_get_contents("http://serwer1869889.home.pl/projekt/api/money_api.php?get_money=category&count=$limit&offset=$offset");
	$res = json_decode($content);
	if(!empty($res)){
		$liczba_fundacji = count($res);
	?>
		<div class="arrows-list"><?php if($page != 1) { ?> <a href="?page=<?php echo $page-1; ?>"><i class="fas fa-angle-left"></i></a> <?php } ?>
		<?php if($liczba_fundacji == $per_page) { ?><a href="?page=<?php echo $page+1; ?>"><i class="fas fa-angle-right"></i></a> <?php } ?></div>
		<table <?php echo 'class="table-'.$page.'"'; ?>>
			<tr>
				<th>#</th>
				<th>Nazwa fundacji</th>
				<th>Dochód 2017</th>
				<th>Kategoria</th>			
			</tr>
			<?php 
	
			if($per_page >= $liczba_fundacji){
				for($i=0;$i<$liczba_fundacji;$i++){
					$k = $offset +  $i+1;
					echo "<tr>";
					echo "<td>".$k."</td>";
					echo '<td><a href="item.php?id='.$res[$i]->id.'">'.$res[$i]->nazwa.'</a></td>';
					echo "<td>".number_format($res[$i]->stan_konta, 2, ',', ' ').' PLN</td>';
					echo "<td>";
					if(empty($res[$i]->categories)){
						echo "Brak danych";
					}else{
						echo $res[$i]->categories;
					}
					echo '</td>';
					echo "</tr>";
				}
			}
				
				?>
		
		
		</table>
	
	
	<?php } ?>
	</div>
	
	
	

	

	<?php require_once("components/footer.php") ?>
	<script src="js/jquery.barrating.min.js"></script>
	<script type="text/javascript">
   $(function() {
      $('#example').barrating({
        theme: 'fontawesome-stars'
      });
   });
   
   autosize($('textarea'));
</script>
</script>
</body>
</html>