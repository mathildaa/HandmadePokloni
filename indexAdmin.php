<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css">
	 <script src="script.js"></script>
	 <script src="notifikacije.js"></script>
    <title>Handmade pokloni by Ivona</title>
</head>
<body>
<div class="page">
    <div class="header">
		<div class="header-menu">
		    <ul>
			<!--<li><div class="header-logo-cnt"><i class="header-logo"><i></i><i></i><i></i><i></i></i></div></li>  -->
			    
				<li><a class="menu-home" href="index.php">POČETNA</a></li>
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
							echo"<li><a class = 'menu-home' href='indexAdmin.php?autor=$jaID'>MOJE NOVOSTI</a></li>";
						}
					?>
				<!--notifikacije-->
					 <?php
						
						if (isset($_SESSION['username'])) 
						{
							echo "<li><a id='notif' href='#'>+ ";
								if(isset($_SESSION['notifikacije'])) 
								{
									echo $_SESSION['notifikacije'];
								}
								else 
								{
									echo "0";
								}
							echo '</a> </li>';
						}
					?>
					<!--notifikacije-->
            </ul>
        </div>
    </div>
	
	<div class="cover">
		<div class="center">
		</div>
	</div>
	
    <div class="main">
        <div class="div-news">
		
		    <div class="Pretraga">
				<select id="dropdown" onchange="dropdownChanged()">
					<option value="sve">Sve novosti</option>
					<option value="danasnje">Danasnje novosti</option>
					<option value="sedmicne">Novosti ove sedmice</option>
					<option value="mjesecne">Novosti ovog mjeseca</option>
				</select>
				<form action = "indexAdmin.php" method = "post">
					<input id="sortiraj" style="height:20px; width:130px" type="submit" name="sortiraj" value="Sortiraj abecedno">
					<input id="sortirajNormalno" style="height:20px; width:130px" type="submit" name="sortirajNormalno" value="Prikazi hronoloski">
				
				</form>
			</div>


               <?php
				session_start();
				date_default_timezone_set('Europe/Sarajevo');
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu->exec("set names utf8");
					if(!isset($_SESSION['username']) ||  $_SESSION['username'] != "ivona") 
					{
						header('Refresh: 0, URL = admin.php');
					}
					if(isset($_POST['obrisiKom']))
					{
						$komID = $_POST['idK'];
						$komentari = $vezaNaBazu->query("select id from komentari where id = $komID");
						if (!$komentari) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
						foreach($komentari as $k)
						{
							$id = $k['id'];
							$podkomentari = $vezaNaBazu->exec("delete from komentari where naKomentar = $id");
						}
						$novosti3 = $vezaNaBazu->exec("delete from komentari where id = $komID");
					}
					
					if(isset($_POST['obrisiPKom']))
					{
						$komID = $_POST['idPK'];
						$podkomentari = $vezaNaBazu->exec("delete from komentari where id = $komID");
					}
					
					
					if(isset($_POST['obrisiNov']))
					{
						$novostID = $_POST['id'];
						$novosti2 = $vezaNaBazu->exec("delete from novost where id = $novostID");
						$komentari = $vezaNaBazu->query("select id from komentari where novost = $novostID");
						if (!$komentari) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
						foreach($komentari as $k)
						{
							$id = $k['id'];
							$podkomentari = $vezaNaBazu->exec("delete from komentari where naKomentar = $id");
						}
						$novosti3 = $vezaNaBazu->exec("delete from komentari where novost = $novostID");
					}
					
					if(isset($_POST['koment']))
					{
						$novostID = $_POST['id'];
						$novost = $vezaNaBazu->query("select komentar from novost where id = $novostID");
						
						$dozvoljeni = 0;
						foreach($novost as $n)
						{
							$dozvoljeni = $n['komentar'];
						}
						if($dozvoljeni) $update = $vezaNaBazu->query("update novost set komentar = 0 where id = $novostID");
						else $update = $vezaNaBazu->query("update novost set komentar = 1 where id = $novostID");
					}
					
					$novosti = $vezaNaBazu->query("select id, naslov, tekst, autor, UNIX_TIMESTAMP(datum) datum, komentar,slika from novost");
					if(isset($_POST['dodajKom']))
					{
						if($_POST['tekstKomentara'] != "")
						{
							$txt = $_POST['tekstKomentara'];
							$naNovost = $_GET['novost'];
							$idKomentara = 1;
							$komentari = $vezaNaBazu->query("select id from komentari");
							foreach($komentari as $k)
							{
								$idKomentara = $k['id'];
							}
							$idKomentara++;
							$autorr = "gost";$idAutor = 0;
							if(!isset($_SESSION['username'])) {$autorr ="gost"; $idAutor = 0;}
							else 
							{
								$autorr = $_SESSION['username'];
								$autori = $vezaNaBazu->query("select id, username from autori");
								$idAutor = 0;
								if (!$autori) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
								foreach($autori as $a)
								{
									if($a['username'] == $autorr) $idAutor = $a['id'];
								}
							}
							$dodavanje = $vezaNaBazu->exec("insert into komentari set id = '$idKomentara', novost = '$naNovost', autor = '$idAutor', sadrzaj = '$txt', vakat = NOW()");
							if (!$dodavanje) {
								  $greska = $vezaNaBazu->errorInfo();
								  print "SQL greška: " . $greska[2];
								  exit();
								}
						}
					}
					
					if(isset($_POST['dodajPKom']))
					{
						if($_POST['podkomentar'] != "")
						{
							$txt = $_POST['podkomentar'];
							$naKom = $_POST['idkom'];
							$idKomentara = 1;
							$komentari = $vezaNaBazu->query("select id from komentari");
							foreach($komentari as $k)
							{
								$idKomentara = $k['id'];
							}
							$idKomentara++;
							if(!isset($_SESSION['username'])) {$autorr ="gost"; $idAutor = 0;}
							else 
							{
								$autorr = $_SESSION['username'];
								$autori = $vezaNaBazu->query("select id, username from autori");
								$idAutor = 0;
								if (!$autori) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
								foreach($autori as $a)
								{
									if($a['username'] == $autorr) $idAutor = $a['id'];
								}
							}
							$dodavanje = $vezaNaBazu->exec("insert into komentari set id = '$idKomentara', naKomentar = '$naKom', autor = '$idAutor', sadrzaj = '$txt', vakat = NOW()");
							if (!$dodavanje) {
								  $greska = $vezaNaBazu->errorInfo();
								  print "SQL greška: " . $greska[2];
								  exit();
								}
						}
					}
					
					if (isset($_POST['sortiraj']))
						$novosti = $vezaNaBazu->query("select  id, naslov, tekst, autor, UNIX_TIMESTAMP(datum) datum, komentar, slika from novost order by naslov asc");
					if (isset($_POST['sortirajNormalno']))
						$novosti = $vezaNaBazu->query("select  id, naslov, tekst, autor, UNIX_TIMESTAMP(datum) datum, komentar, slika from novost order by datum desc");
					$brojac = 1;
					
					if(isset($_GET['autor']))
					{
						if($_GET['autor'] == 0) {}
						else{
							$a = $_GET['autor'];
							$novosti = $vezaNaBazu->query("select  id, naslov, tekst, autor, UNIX_TIMESTAMP(datum) datum, komentar, slika from novost where autor = '$a' order by datum desc");
							
						}
					}
					
					foreach ($novosti as $n)
					{
						$src = "media/".($n['slika']);
						$alt = "Slika"; 
						$datum = date("Y-m-d H:i:s", $n['datum']);
						$naslov = $n['naslov'];
						$tekst = $n['tekst'];
						$autor = $n['autor'];
						$id = $n['id'];
						
						$brNeprocitanih = 0;
						$neprocitani = $vezaNaBazu->query("select count(*) from komentari where novost = $id and procitan = 0");
						foreach($neprocitani as $k)
						{	
							$brNeprocitanih += $k['count(*)'];
						}
						$podkomentari = $vezaNaBazu->query("select count(*) from komentari k1, komentari k2, novost n where k1.naKomentar = k2.id and k2.novost = n.id and n.id = $id and k1.procitan = 0");
						foreach($podkomentari as $k)
						{
							$brNeprocitanih += $k['count(*)'];
						}
						
						$autori = $vezaNaBazu->prepare("select username from autori where id=$autor");
						$autori -> execute();
						$kom = $n['komentar'];
						$ispisautor = "";
						$autorhref = 0;
						if(isset($_GET['autor'])){$autorhref = $autor;}
						if($_GET['autor'] == 0){$autorhref = 0;}
						foreach($autori as $a) $ispisautor = $a['username'];
						print "<form method='post'><div class='news'>				
									<div class = 'news-title'>$naslov</div>
									<label class = 'Datum'>$datum</label>
									<label class = 'Proslo'></label>
									<label class = 'Datum1'>$datum</label>
									<br>
									<div class='news-content'>
										<img class = 'news-imgL' src=$src alt=$alt>
										<div class = 'news-txt'> $tekst </div>
										<br>
										<input type='hidden' name='id' value='$id'> 
										<a class = 'Autor' href='indexAdmin.php?autor=$autor'>Objavio $ispisautor</a>
										<br>
										<a class = 'Autor' href='indexAdmin.php?novost=$id&autor=$autorhref'>Detaljno...($brNeprocitanih)</a>
										<input class='obrisiNov' type='submit' name='obrisiNov' value='Obrisi novost'>
										<input class='koment' type='submit' name='koment' style='width:120px' value='Dozvoli/Zabrani komentare'>
									</div>
									<div class='empty'></div>
								</div></form>";
						if(isset($_GET['novost'])  && $_GET['novost'] == $id)
						{
							if($kom){
							$id = $_GET['novost'];
							$komentari = $vezaNaBazu->query("select id, sadrzaj, autor from komentari where novost = $id");
							if(isset($_SESSION['username']) && $_SESSION['username'] == $ispisautor) //notifikacije
							{
								$procitani = $vezaNaBazu->query("update komentari set procitan = 1 where novost = $id"); 
								}
							foreach($komentari as $k)
							{
								$autor = $k['autor'];
								$autorIme;
								$idK = $k['id'];
									if($autor == 0) $autorIme = "gost";
									else
									{
										$autori = $vezaNaBazu->query("select id, username from autori where id = $autor");
										foreach($autori as $a)
										{
											$autorIme = $a['username'];
										}
									}
								print "<form method='post'>
										<div class='komentariSlika'>
										<div class='komentari'>		
											<div class = 'news-txt'>
												<p>".$k['sadrzaj']."</p><BR>
												<a class = 'Autor' href='indexAdmin.php?autor=$autor'>by: $autorIme</a>
												<input class='obrisiKom' type='submit' name='obrisiKom' value='Obrisi komentar'>
												<input type='hidden' name='idK' value='$idK'> 
											</div>
										</div>
									</div></form>";
								$idKomentara = $k['id'];	
								$komNaKom = $vezaNaBazu->query("select id, sadrzaj, autor from komentari where naKomentar = '$idKomentara'");
								if(isset($_SESSION['username']) && $_SESSION['username'] == $ispisautor) //notifikacije
								{
									$procitaniPodKom = $vezaNaBazu->query("update komentari set procitan = 1 where naKomentar = '$idKomentara'");
								}
								foreach($komNaKom as $k)
								{
									$autor = $k['autor'];
									$autorIme;
									$idPK = $k['id'];
									if($autor == 0) $autorIme = "gost";
									else
									{
										$autori = $vezaNaBazu->query("select id, username from autori where id = $autor");
										foreach($autori as $a)
										{
											$autorIme = $a['username'];
										}
									}
									print "<form method='post'><div class='PodkomentariSlika'>
										<div class='komentari'>		
											<div class = 'news-txt'>
												<p>".$k['sadrzaj']."</p>
												<a class = 'Autor' href='indexAdmin.php?autor=$autor'>by: $autorIme</a>
												<input class='obrisiPKom' type='submit' name='obrisiPKom' value='Obrisi komentar'>
												<input type='hidden' name='idPK' value='$idPK'> 
											</div>
										</div>
									</div></form>";	
								}
								print "<form action='indexAdmin.php?novost=$id' method='post'>
									<div class='PodkomentariSlika'>
									
									<textarea placeholder = 'Odgovorite na ovaj komentar' name='podkomentar' rows='2' cols = '87'></textarea>
									<input class='dodajPKom' type='submit' name='dodajPKom' value='Pošalji'>
									<input type='hidden' name='idkom' value='$idKomentara'> 
									
									</div></form>";
							}
							print "<form action='indexAdmin.php?novost=$id' method='post'>
									<div class='komentariSlika'>
									
									<textarea placeholder = 'Dodajte novi komentar' name='tekstKomentara' rows='5' cols = '80'></textarea>
									<input class='dodajKom' type='submit' name='dodajKom' value='Pošalji'>
									
									
									</div></form>";
									}
							else print "<div class='PodkomentariSlika'>
										<div class='komentari'>		
											<div class = 'news-txt'>
												<p>komentari su zabranjeni za ovu novost</p>
											</div>
										</div>
									</div>";	
						}	
					} 
				?>	
        </div>
    </div>
</div>

</body>
</html>