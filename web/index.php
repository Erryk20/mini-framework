<?php
use core\App;

require_once(__DIR__ . '/../autoload.php');
$config = require_once(__DIR__ . '/../config/main.php');

try {
	App::run($config);
} catch (Exception $e) {
	echo $e->getMessage();
}
