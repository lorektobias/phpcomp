<?php

function autoload($class)
{
	$file = __DIR__ . "/src/{$class}.php";
	$file = str_replace('\\', '/', $file);
	if (file_exists($file)) {
		require_once $file;
		return true;
	} else {
		return false;
	}
}
spl_autoload_register('autoload');
