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

// Using IPLocate.io free databases (CC BY-SA 4.0) instead of MaxMind GeoLite
// which changed to restrictive licensing in 2019
// https://github.com/iplocate/ip-address-databases
$Reader = new MaxMind\Db\Reader('/usr/share/GeoIP/ip-to-country.mmdb');

$Return = [];
if (isset($_POST['ip']) && is_array($_POST['ip'])) {
    foreach ($_POST['ip'] as $IP) {
        /**
         * @var ?array{
         *     continent_code: string,
         *     country_code: string,
         *     country_name: string,
         * } $record
         */
        $record = $Reader->get($IP);

        if ($record === null) {
            $Return[] = ['ip' => $IP, 'info' => ['country' => 'un', 'host' => $IP]];
        } else {
            $Return[] = ['ip' => $IP, 'info' => ['country' => strtolower($record['country_code']), 'host' => $IP]];
        }
    }
}

echo json_encode($Return);
