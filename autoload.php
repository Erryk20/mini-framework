<?php

spl_autoload_register(function ($className) {
	$file = str_replace('\\', '/',  __DIR__ . '/' . $className) . '.php';
	if (file_exists($file)) {
		include $file;
	} else {
		throw new ErrorException("\n{$className} class cannot find.");
	}
});