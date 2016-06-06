<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Handmade pokloni</title>
</head>
<body>
<?php	//ovo je prava verzija
		//file_put_contents("loginFile.csv", "ivona,".password_hash("ivona", PASSWORD_BCRYPT));
		$poruka = "";
		require_once('password.php');					
		if (isset($_POST['prijava'])){
			$user = $_POST['username'];
			$pw = $_POST['password'];
			define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
					define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
					define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
					define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
					define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
					$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
					$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
			$logovani = $vezaNaBazu->query("select username, password from autori");
			$uspjesno = false;
			foreach($logovani as $l)
			{
				if(password_verify($pw, $l['password']) && $l['username'] == 'ivona') 
				{
				session_start();
					$uspjesno = true; 
					$_SESSION['username'] = 'ivona';
				}
				if(password_verify($pw, $l['password']) && $l['username'] != 'ivona') 
				{
				session_start();
					$uspjesno = true; 
					$_SESSION['username'] = $l['username'];
				}
			}
			if ($uspjesno && $_SESSION['username'] == "ivona") 
			{
				$poruka = "Uspješno ste prijavljeni učitavam admin panel...";		
				header('Refresh: 1; URL = adminPocetna.php');
			}
			else if ($uspjesno) 
			{
				$poruka = "Uspješno ste prijavljeni učitavam korisnički panel...";		
				header('Refresh: 1; URL = korisnickiPanel.php');
			}
			else
		$poruka = "Neuspjesna prijava!";
		}

	?>

	<div class="page">
		<div class="header">
			<div class="header-menu">
				<ul>
				<!--<li><div class="header-logo-cnt"><i class="header-logo"><i></i><i></i><i></i><i></i></i></div></li>  -->
					
					<li><a class="menu-home" href="index.php">POČETNA</a></li>
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
						<div class="centar">
							<form action="admin.php" method="post">
								<table class = "login-tabela">
									<tbody>
										<tr>
											<td colspan = "2">
												<b>Prijavite se!</b>
											</td>
										</tr>
										<tr>
											<td><input autofocus type = "text" name = "username" placeholder = "Username"></td>
										</tr>
										<tr>
											<td><input name = "password" placeholder = "Password"></td>
										</tr>
										<tr>
											<td><input id="dugme" type="submit" name="prijava" value="Prijava"></td>
										</tr>
										<tr> 
											<td colspan = "2">
												<?php echo $poruka; ?>
											</td> 
										</tr>
									</tbody>
								</table>
							</form>	
						</div>
					</div>
				</div>
			</div>
	</div>

</body>
