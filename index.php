<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/style.css">
	 <script src="script.js"></script>
    <title>Handmade pokloni by Ivona</title>
</head>
<body>
<div class="page">
    <div class="header">
		<div class="header-menu">
		    <ul>
			<!--<li><div class="header-logo-cnt"><i class="header-logo"><i></i><i></i><i></i><i></i></i></div></li>  -->
			    
				<li><a class="menu-home" href="index.html">POČETNA</a></li>
                <li><a class="menu-links" href="linkovi.html">LINKOVI</a></li>
                <li><a class="menu-links" href="tabela.html">Tabela</a></li>
                <li><a class="menu-contacts" href="kontakt.html">KONTAKT</a></li>,
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
		
		    <div class="Pretraga">
				<select id="dropdown" onchange="dropdownChanged()">
					<option value="sve">Sve novosti</option>
					<option value="danasnje">Danasnje novosti</option>
					<option value="sedmicne">Novosti ove sedmice</option>
					<option value="mjesecne">Novosti ovog mjeseca</option>
				</select>
			</div>
               <?php
					$novosti = file("novosti.csv");
					$brojac = 1;
					for ($i = sizeof($novosti)-1; $i >= 0; $i--)
					{
						$n = explode(",", $novosti[$i]); 
						$src = "media/".($n[1]);
						print "<div class='news'>				
									<div class = 'news-title'>$n[0]</div>
									<label class = 'Datum'>$n[3]</label>
									<label class = 'Proslo'></label>
									<label class = 'Datum1'>$n[3]</label>
									<br>
									<div class='news-content'>
										<div class = 'news-txt'>$n[2] </div>
										<img class = 'news-imgL' src=$src alt=\"Slika\">
									</div>
									<div class='empty'></div>
								</div>";
						print "<BR class='empty'>";
						$brojac++;
					}
				?>	
        </div>
    </div>
</div>

</body>
</html>