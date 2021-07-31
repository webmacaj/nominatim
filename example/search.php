<?php
require_once __DIR__ . '/../vendor/autoload.php';

$nominatim = new \Webmacaj\Nominatim\NominatimApi();
$result = $nominatim->search([
    'query' => 'Castle, 811 06, Bratislava, Slovakia'
]);