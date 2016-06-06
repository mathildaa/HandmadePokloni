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
	require_once('password.php');
	if(!isset($_SESSION['username']) ||  $_SESSION['username'] != "ivona") 
	{
		header('Refresh: 0, URL = admin.php');
	}
	else
	{
		$porukaAdmin = "";	
		if(isset($_POST['uredi']))
		{
			if($_POST['username'] == "" ) $porukaAdmin = "Niste unijeli username!";
			else
			{	
				$user = $_POST['username'];
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
				$id = 1;
				
				$autori = $vezaNaBazu->query("select id, username from autori");
				$postoji = false;
				foreach($autori as $a)
				{
						if($a['username'] == $user) 
						{
							$postoji = true;
							$id = $a['id'];
						}
				}
				if($user == 'ivona')
				{
					$porukaAdmin = "e sipak!";
				}
				else if(!$postoji)
					$porukaAdmin = "Korisnik sa tim usernameon ne postoji";
				else
				{
					if($_POST['username1'] == "" ) $porukaAdmin = "Niste unijeli novi username!";
					else if($_POST['password'] == "" ) $porukaAdmin = "Niste unijeli novi password!";
					else{
						$un = $_POST['username1'];
						$pw = $_POST['password'];
						$pw = password_hash($pw, PASSWORD_DEFAULT);
						$autori = $vezaNaBazu->query("update autori set username = '$un', password = '$pw' where username = '$user'");
						$porukaAdmin = "Korisnik promijenjen";
					}
					
					
					
				}
				
			}
		}
		if(isset($_POST['izadji']))
		{
			
			header('Refresh: 0, URL = adminPocetna.php');
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
										<p>Unesite podatke novog korisnika</p>
									</div>
									<div id = "desno">
										<div class="desno-cont">
											<input placeholder = "Stari username" autofocus type = "text" size = "42" name = "username" >
											<input placeholder = "Novi username" autofocus type = "text" size = "42" name = "username1" >
											<input placeholder = "Novi password" autofocus type = "text" size = "42" name = "password" >
										</div>
										<div class="desno-cont">
											<label class="crveno"><?php echo $porukaAdmin; ?></label>
										</div>
											<input id="uredi" style="height:50px; width:120px" type="submit" name="uredi" value="Uredi korisnika">
											<input id="izadji" style="height:50px; width:120px" type="submit" name="izadji" value="Nazad">
										
									</div>
										
						
										
									
							</form>
					</div>
				</div>
			</div>
	</div>

</body>
</html>