<?php
require 'vendor/autoload.php';

$client = new \Marketcall\Client("764a85b9fd8c1ccdff1f3e5f66dae8f7dad15606");
$offer = $client->getAccounts();
var_dump($offer);
