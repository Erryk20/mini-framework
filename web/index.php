<?php
use core\App;

require_once '../vendor/autoload.php';
$config = require(__DIR__ . '/../config/main.php');

try {
	App::run($config);
} catch (Exception $e) {
	echo $e->getMessage();
}
