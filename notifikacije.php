<?php
    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
	define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
	define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
	define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
	define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
	$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
	$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
    session_start();
		$broj = 0;
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
	$komentari = $vezaNaBazu->query("select count(*) from komentari k, novost n where k.novost = n.id and n.autor = $idAutor and k.procitan = 0");
	if (!$komentari) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
	$podkomentari = $vezaNaBazu->query("select count(*) from komentari k1, komentari k2, novost n where k1.naKomentar = k2.id and k2.novost = n.id and n.autor = $idAutor and k1.procitan = 0");
	if (!$podkomentari) {
									  $greska = $vezaNaBazu->errorInfo();
									  print "SQL greška: " . $greska[2];
									  exit();
									}
	foreach($komentari as $k)
	{
		$broj += $k['count(*)'];
	}
		foreach($podkomentari as $k)
	{
		$broj += $k['count(*)'];
	}
	echo $broj;
?>