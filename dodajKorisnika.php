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
		if(isset($_POST['dodaj']))
		{
			if($_POST['username'] == "" ) $porukaAdmin = "Niste unijeli username!";
			else if($_POST['password1'] == "") $porukaAdmin = "Niste unijeli password!";
			else if($_POST['password2'] == "") $porukaAdmin = "Morate ponoviti password!";
			else if($_POST['password1'] != $_POST['password2']) $porukaAdmin = "Passwordi se ne podudaraju!";
			else
			{	
				$user = $_POST['username'];
				$pw = $_POST['password1'];
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
				$id = 1;
				
				$autori = $vezaNaBazu->query("select id, username from autori");
				if (!$autori) {
					  $greska = $vezaNaBazu->errorInfo();
					  print "SQL greška: " . $greska[2];
					  exit();
					}
				$postoji = false;
				foreach($autori as $a)
				{		$id =$a['id'];
						if($a['username'] == $user) $postoji = true;
				}
				if($postoji)
					$porukaAdmin = "Korisnik sa tim usernameon vec postoji";
				else
				{		
				$id++;
						$hash = password_hash($pw, PASSWORD_DEFAULT); 
						$autori1 = $vezaNaBazu->exec("insert into autori(id, username, password) values($id,'$user', '$hash')");
							if (!$autori1) {
							  $greska = $vezaNaBazu->errorInfo();
							  print "SQL greška: " . $greska[2];
							  exit();
							}
						$porukaAdmin = "Korisnik dodan";
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
					<li><a class="menu-home" href="index.php">POÈETNA</a></li>
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
											<input placeholder = "Unesite username" autofocus type = "text" size = "42" name = "username" >
										</div>
										<div class="desno-cont">
											<input placeholder = "Unesite password" autofocus type = "text" size = "42" name = "password1" >
										</div>
										<div class="desno-cont">
											<input placeholder = "Ponovite password" autofocus type = "text" size = "42" name = "password2" >
										</div>
										<div class="desno-cont">
											<label class="crveno"><?php echo $porukaAdmin; ?></label>
										</div>
											<input id="dodaj" style="height:50px; width:120px" type="submit" name="dodaj" value="Dodaj korisnika">
											<input id="izadji" style="height:50px; width:120px" type="submit" name="izadji" value="Nazad">
										
									</div>
										
						
										
									
							</form>
					</div>
				</div>
			</div>
	</div>

</body>
</html>