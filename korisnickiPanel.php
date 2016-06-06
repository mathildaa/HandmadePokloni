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

		if(isset($_POST['izadji']))
		{
			session_destroy();
			header('Refresh: 0, URL = admin.php');
		}
		
		if(isset($_POST['promijeni']))
		{
			header('Refresh: 0, URL = promijeniSifru.php');
		}
		if(isset($_POST['dodajNovost']))
		{
			header('Refresh: 0, URL = korisnikDodajNovost.php');
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
					<li><a class="menu-admin" href="preusmjeravanje.php">KORISNICKE OPCIJE</a></li>
					<?php 
					define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu->exec("set names utf8");
						session_start(); 
						if (isset($_SESSION['username'])) 
						{
							$ja = $_SESSION['username'];
							$jaID = 0;
							$korisnik = $vezaNaBazu->query("select id from autori where username = '$ja'");
							foreach($korisnik as $k)
							{
								$jaID = $k['id'];
							}
							echo"<li><a class = 'menu-home' href='index.php?autor=$jaID'>MOJE NOVOSTI</a></li>";
						}
					?>
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
											<input id="izadji" style="height:50px; width:120px" type="submit" name="izadji" value="Izadji">
											<input id="promijeni" style="height:50px; width:120px" type="submit" name="promijeni" value="Promijeni Sifru">
											<input id="dodajNovost" style="height:50px; width:120px" type="submit" name="dodajNovost" value="Dodaj novost">
									
									
									
							</form>
					</div>
				</div>
			</div>
	</div>

</body>
</html>