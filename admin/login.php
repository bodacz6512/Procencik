<?php

session_start();

if(isset($_POST['haslo'])){
	
	if($_POST['haslo'] == "6512"){
		
		$_SESSION['logged'] = true;
		header("Location:slowa.php");
	}else{
		$bad = true;
	}
	
}

if(isset($_SESSION['logged'])){
	header("Location: slowa.php");
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<?php require("components/header.php") ?>
	<style>
	body#LoginForm{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;
	height:100vh;
	display:flex;
	align-items:center;
	}

.form-heading { color:#fff; font-size:23px;}
.panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
.panel p { color:#777777; font-size:14px; margin-bottom:30px; line-height:24px;}
.login-form .form-control {
  background: #f7f7f7 none repeat scroll 0 0;
  border: 1px solid #d4d4d4;
  border-radius: 4px;
  font-size: 14px;
  height: 50px;
  line-height: 50px;
}
.main-div {
  background: #ffffff none repeat scroll 0 0;
  border-radius: 2px;
  margin: 10px auto 30px;
  max-width: 38%;
  padding: 50px 70px 70px 71px;
  margin-top:-50px;
}

.login-form .form-group {
  margin-bottom:10px;
}
.login-form{ text-align:center;}
.forgot a {
  color: #777777;
  font-size: 14px;
  text-decoration: underline;
}
.login-form  .btn.btn-primary {
  background: #f0ad4e none repeat scroll 0 0;
  border-color: #f0ad4e;
  color: #ffffff;
  font-size: 14px;
  width: 100%;
  height: 50px;
  line-height: 50px;
  padding: 0;
}
.forgot {
  text-align: left; margin-bottom:30px;
}
.botto-text {
  color: #ffffff;
  font-size: 14px;
  margin: auto;
}
.login-form .btn.btn-primary.reset {
  background: #ff9900 none repeat scroll 0 0;
}
.back { text-align: left; margin-top:10px;}
.back a {color: #444444; font-size: 13px;text-decoration: none;}

	</style>
</head>
<body id="LoginForm">
<div class="container">
<div class="login-form">
<?php if(isset($bad)){ ?>
<div class="alert alert-danger" style="max-width:400px;margin-bottom:40px;margin:auto;margin-bottom:80px;" role="alert">
  Wprowadzone hasło jest nieprawidłowe :/
</div>

<?php } ?>
<div class="main-div">
    <div class="panel">
	
	
   <h2>Admin Login</h2>
   <p>Wprowadź hasło</p>
   </div>
    <form id="Login" method="post">

        <div class="form-group">

            <input type="password" name="haslo" class="form-control" id="inputPassword" placeholder="Hasło">

        </div>
        <div class="forgot">
</div>
        <button type="submit" class="btn btn-primary">Zaloguj</button>

    </form>
    </div>
</div></div></div>


	<?php require("components/footer.php") ?>
</body>
</html>
