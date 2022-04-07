<?php
require '../vendor/autoload.php';

use App\Service\GetDistanceBetweenPointsService;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if($uri[1] !== 'get-distance'){
	header("HTTP/1.1 404 Not Found");
	exit();
}

$firstLatitude = (float)$_GET["firstLatitude"];
$firstLongitude = (float)$_GET["firstLongitude"];

$secondLatitude = (float)$_GET["secondLatitude"];
$secondLongitude = (float)$_GET["secondLongitude"];

if($firstLatitude === null ||
	$firstLongitude === null ||
	$secondLatitude === null ||
	$secondLongitude === null
) {
	# parameters REQUIRED
	header("HTTP/1.1 500 Required params not found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$controller = new GetDistanceBetweenPointsService(
	$requestMethod,
	$firstLatitude,
	$firstLongitude,
	$secondLatitude,
	$secondLongitude
);

$controller->processRequest();
