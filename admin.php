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
		require_once('password.php');
		$loginPodaci = file("loginFile.csv");
		$podaci = explode(",", $loginPodaci[0]);
		$ime = $podaci[0];
		$sifra = $podaci[1];
		$poruka = "";						
		if (isset($_POST['prijava']) && $_POST['username'] == $ime && password_verify($_POST['password'], $sifra)){
				session_start();
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['username'] = $ime;	
			$poruka = "Uspješno ste prijavljeni učitavam admin panel...";		
			header('Refresh: 1; URL = adminPanel.php');
		}
		else if(isset($_POST['prijava']) && ($_POST['username'] != $ime || !password_verify($_POST['password'], $sifra)))
		 $poruka = "Neuspjesna prijava!";
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
					<li><a class="menu-admin" href="adminPanel.php">ADMIN PANEL</a></li>
					
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
</html>