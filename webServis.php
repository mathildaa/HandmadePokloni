<?php
function zag() {
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: text/html');
    header('Access-Control-Allow-Origin: *');
}
function rest_get($request, $data) 
{
	define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
	define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
	define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
	define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
	define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
	$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
	$vezaNaBazu = new PDO($dsn, DB_USER, DB_PASS);$vezaNaBazu -> exec("set names utf8");
	$x = $data['x'];
	$autor = $data['autor'];
	$autori = $vezaNaBazu->query("select id from autori where username = '$autor'");
	$id = 0;
	if (!$autori) {
					  $greska = $vezaNaBazu->errorInfo();
					  print "SQL greška: " . $greska[2];
					  exit();
					}
	foreach($autori as $a)
	{
		$id = $a['id'];
	}
	$novosti = $vezaNaBazu->query("select count(id) from novost where autor = '$id'");
	$brojac = 0;
	foreach($novosti as $n)
	{
		$brojac = $n['count(id)'];
	}
	if($id == 0) print "Taj korisnik nije u bazi";
	else if($brojac >= $x)
	{
		$novosti2 = $vezaNaBazu->prepare("SELECT * FROM novost WHERE autor=?");
		$novosti2->bindValue(1, $id, PDO::PARAM_INT);
		$novosti2->execute();
		$novosti1 = $novosti2->fetchAll();
		$niz = array();
		for ($i = 0; $i < $x; $i++)
			array_push($niz, $novosti1[$i]);
		
		print "{ \"novosti\": " . json_encode($niz) . "}";
	}	
	else
	{
		print "Trazite vise novosti nego sto ih je autor dodao. Autor ih je dodao ".$brojac.".";
	}
}
function rest_post($request, $data) { }
function rest_delete($request) { }
function rest_put($request, $data) { }
function rest_error($request) { }
$method  = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];
switch($method) {
    case 'PUT':
        parse_str(file_get_contents('php://input'), $put_vars);
        zag(); $data = $put_vars; rest_put($request, $data); break;
    case 'POST':
        zag(); $data = $_POST; rest_post($request, $data); break;
    case 'GET':
        zag(); $data = $_GET; rest_get($request, $data); break;
    case 'DELETE':
        zag(); rest_delete($request); break;
    default:
        header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        rest_error($request); break;
}
?>