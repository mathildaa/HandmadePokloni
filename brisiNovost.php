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
	if(!isset($_SESSION['username']) ||  $_SESSION['username'] != "ivona") 
	{
		header('Refresh: 0, URL = admin.php');
	}
	else
	{
		$porukaAdmin = "";	
		if(isset($_POST['brisi']))
		{
			if($_POST['naslov'] == "" ) $porukaAdmin = "Niste unijeli naslov!";
			else
			{	
				$naslov = $_POST['naslov'];
				$naslov = strtoupper($naslov);
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
				
				$novosti = $vezaNaBazu->query("select naslov from novost");
				$postoji = false;
				foreach($novosti  as $a){
						if($a['naslov'] == $naslov) 
						{
							$postoji = true;
						}
				}
				if(!$postoji)
					$porukaAdmin = "Novost s tim naslovom ne postoji";
				else
				{
						$novosti2 = $vezaNaBazu->exec("delete from novost where naslov = '$naslov'");
							  if (!$novosti2) {
					  $greska = $vezaNaBazu->errorInfo();
					  print "SQL greška: " . $greska[2];
					  exit();
					}
						$porukaAdmin = "Novost obrisan";
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
											<input placeholder = "Unesite naslov" autofocus type = "text" size = "42" name = "naslov" >
										</div>
										<div class="desno-cont">
											<label class="crveno"><?php echo $porukaAdmin; ?></label>
										</div>
											<input id="brisi" style="height:50px; width:120px" type="submit" name="brisi" value="Brisi novost">
											<input id="izadji" style="height:50px; width:120px" type="submit" name="izadji" value="Nazad">
										
									</div>
										
						
										
									
							</form>
					</div>
				</div>
			</div>
	</div>

</body>
</html>