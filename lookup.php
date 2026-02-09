<?php

declare(strict_types=1);

header('Content-type: application/json');

if (is_file(__DIR__ . "/vendor/autoload.php")) {
    // Dependencies installed via composer
    require(__DIR__ . "/vendor/autoload.php");
} elseif (is_file('/usr/share/php/GeoIP2/autoload.php')) {
    // Dependencies installed via Fedora autoloader
    require('/usr/share/php/GeoIP2/autoload.php');
} else {
    http_response_code(501);
    exit;
}

use GeoIp2\Database\Reader AS GeoIP2;
use GeoIp2\Exception\AddressNotFoundException;

$Return = [];

$GeoIP = new GeoIP2('/usr/share/GeoIP/dbip-country-lite.mmdb');

if (isset($_POST['ip']) && is_array($_POST['ip'])) {
    foreach ($_POST['ip'] as $IP) {
        try {
            $Return[$IP] = strtolower($GeoIP->country($IP)->country->isoCode);
        } catch (AddressNotFoundException $e) {
            $Return[$IP] = 'un';
        }
    }
}

echo json_encode($Return);
