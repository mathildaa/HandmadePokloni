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
	if(!isset($_SESSION['username']) ) 
	{
		header('Refresh: 0, URL = admin.php');
	}
	else if(isset($_SESSION['username']) &&  $_SESSION['username'] != "ivona") 
	{
		header('Refresh: 0, URL = korisnickiPanel.php');
	}
	else if(isset($_SESSION['username']) &&  $_SESSION['username'] == "ivona") 
	{
		header('Refresh: 0, URL = adminPocetna.php');
	}
	
	?>

	<div class="page">
		
	</div>

</body>
</html>