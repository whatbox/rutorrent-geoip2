<?php
declare(strict_types=1);

require(__DIR__ . "/vendor/autoload.php");

if (!class_exists("GeoIp2\Database\Reader")) {
	$jResult .= "plugin.disable();";
}

$theSettings->registerPlugin($plugin["name"],$pInfo["perms"]);
