<?php
// function loadEnv($path)
// {
// 	if (!file_exists($path)) {
// 		throw new Exception("Environment file not found.");
// 	}

// 	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
// 	foreach ($lines as $line) {
// 		if (strpos(trim($line), '#') === 0) {
// 			continue;
// 		}

// 		list($key, $value) = explode('=', $line, 2);
// 		putenv("$key=$value");
// 	}
// }




// // loadEnv('/home/u273960544/domains/palawansu-usg.com/public_html/palawansu-usg/usg_tiniguiban.env');  // ----- PRODUCTION   ----- //
// loadEnv(__DIR__ . '/../.env');                          // ----- DEVELOPMENT  ----- //



// date_default_timezone_set("Asia/Manila");
// $charset = 'utf8mb4';


// $hostname = getenv('DB_HOST');
// $port = getenv('DB_PORT');
// $username = getenv('DB_USER');
// $password = getenv('DB_PASS');
// $defaultSchema = getenv('DB_NAME');
// $charset = getenv('DB_CHARSET');

$hostname = "localhost";
$port = "3306";
$username = "root";
$password = "";
$defaultSchema = "slurp";
$charset = "utf8mb4";

// $hostname = "77.37.35.51";
// $port = "3306";
// $username = "u273960544_kisser";
// $password = "h1g0pM4l4l4*";
// $defaultSchema = "u273960544_slurp";
// $charset = "utf8mb4";

$dsn = "mysql:host=$hostname;dbname=$defaultSchema;charset=$charset;port=$port";

$option = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false
];

global $pdo;
$pdo = new PDO($dsn, $username, $password, $option);

