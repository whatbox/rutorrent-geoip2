<?php
declare(strict_types=1);

if (is_file(__DIR__ . "/vendor/autoload.php")) {
	// Dependencies installed via composer
	require(__DIR__ . "/vendor/autoload.php");
} elseif (is_file('/usr/share/php/GeoIP2/autoload.php')) {
	// Dependencies installed via Fedora autoloader
	require('/usr/share/php/GeoIP2/autoload.php');
} else {
	$jResult .= "plugin.disable();";
}

if (!class_exists("GeoIp2\Database\Reader")) {
	$jResult .= "plugin.disable();";
}

$theSettings->registerPlugin($plugin["name"],$pInfo["perms"]);
