<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Handmade pokloni</title>
	<script src="validacije.js" type="text/javascript"></script>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION['username'])) 
	{
		header('Refresh: 0, URL = admin.php');
	}
	else
	{
		$user = $_SESSION['username'];
		
	require_once('password.php');
		$porukaAdmin = "";	
		if(isset($_POST['izmijeni']))
		{
			if($_POST['pw1'] == "" ||  $_POST['pw2'] == ""|| $_POST['pw3']== "") $porukaAdmin = "Niste unijeli sve podatke!";
			else if($_POST['pw2'] != $_POST['pw3']) $porukaAdmin = "Novi passwordi se razlikuju!";
			else
			{	
				$pass2 = $_POST['pw2'];
				$pass2 = password_hash($pass2, PASSWORD_DEFAULT);
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
				$autori = $vezaNaBazu->query("update autori set password = '$pass2' where username = '$user'");
				$porukaAdmin = "Password promijenjen";
				
			}
		}
		if(isset($_POST['izadji']))
		{
			header('Refresh: 0, URL = korisnickiPanel.php');
		}
	}
	?>

	<div class="page">
		<div class="header">
			<div class="header-menu">
				<ul>
				<!--<li><div class="header-logo-cnt"><i class="header-logo"><i></i><i></i><i></i><i></i></i></div></li>  -->
					<li><a class="menu-home" href="index.php">POCETNA</a></li>
					<li><a class="menu-links" href="linkovi.html">LINKOVI</a></li>
					<li><a class="menu-links" href="tabela.html">Tabela</a></li>
					<li><a class="menu-contacts" href="kontakt.html">KONTAKT</a></li>
					<li><a class="menu-admin" href="preusmjeravanje.php">LOGIN/LOGOUT</a></li>
				</ul>
			</div>
		</div>
		<div class="cover">
			<div class="center">
			</div>
		</div>
			<div class="main">
				<div class="div-news">
					<div class="news">	
							<form id="forma" method="post">					
									<div id="lijevo">
										<p>Unesite novi password</p>
									</div>
									<div id = "desno">
										<div class="desno-cont">
											<input placeholder = "Stari password" autofocus type = "text" size = "42" name = "pw1" >
											<input placeholder = "Novi password" autofocus type = "text" size = "42" name = "pw2" >
											<input placeholder = "Ponovite novi password" autofocus type = "text" size = "42" name = "pw3" >
										</div>
										<div class="desno-cont">
											<label class="crveno"><?php echo $porukaAdmin; ?></label>
										</div>
											<input id="izmijeni" style="height:50px; width:120px" type="submit" name="izmijeni" value="Izmijeni">
											<input id="izadji" style="height:50px; width:120px" type="submit" name="izadji" value="Nazad">
										
									</div>
										
						
										
									
							</form>
					</div>
				</div>
			</div>
	</div>

</body>
</html>