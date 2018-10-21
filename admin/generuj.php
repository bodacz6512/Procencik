<?php 

session_start();
unset($_SESSION['failed']);
require("connect.php");
if(!isset($_SESSION['logged'])){
	
	header("Location: login.php");
	exit;
}


?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require("components/header.php") ?>
	
	<style>
	table i{
		font-size:40px;
	}
	</style>
</head>
<body>


<?php require("components/nav.php")  ?> 

  <div id="content">
  
	<div class="jumbotron">
		<h1 class="display-4">Witaj!</h1>
		<p class="lead">Jesteś w potężnym narzędziu które segeruje rekordy w bazie pod słowa kluczowe. </p>
		<hr class="my-4">
		<p>W zależności od łącza może to potrwać nawet 5 minut.</p>
		<a class="btn btn-primary btn-lg" href="#" role="button" onclick="generuj()">Włącz</a>
</div>






	
	
	
	
	</div>
</div>	

	<?php require("components/footer.php") ?>
	<script>
	
	function generuj(){
		
		swal({
			title: 'Poczekaj...',
			html: 'Trwa wykonywanie operacji... Może to chwile potrwać',
			onOpen: () => {
				swal.showLoading()
			  }
		});
		
		ajaksuj();
	}
	
	
	function ajaksuj(){
		
		do {
		$.ajax({
			type: 'POST',
			url: 'generuj_kategorie.php',
			data: { 
			},
			success: function(msg){
				

					swal(
					  '100%',
					  'Wykonano ' + msg + ' zapytań do bazy',
					  'success'
					)
					
	
				

			}		
		});	
		}
		while(msg.indexOf("FINALLY") != -1);
		
		
	}
	
	
	</script>
</body>
</html>