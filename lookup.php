<?php
header('Content-type: application/json');

if (is_file(__DIR__ . "/vendor/autoload.php")) {
        // Dependencies installed via composer
        require(__DIR__ . "/vendor/autoload.php");
} elseif (is_file('/usr/share/php/GeoIP2/autoload.php')) {
        // Dependencies installed via Fedora autoloader
        require('/usr/share/php/GeoIP2/autoload.php');
}

use GeoIp2\Database\Reader AS GeoIP2;

$Return = [];

$GeoIP2 = new GeoIP2('/usr/share/GeoIP/GeoLite2-Country.mmdb');

if (isset($_POST['ip']) && is_array($_POST['ip'])) {
	foreach ($_POST['ip'] as $IP) {
		try {
			$Return[] = ['ip' => $IP, 'info' => ['country' => strtolower($GeoIP2->country($IP)->country->isoCode), 'host' => $IP]];
		} catch (Exception $e) {
			$Return[] = ['ip' => $IP, 'info' => ['country' => 'un', 'host' => $IP]];
		}
	}
}

echo json_encode($Return);
