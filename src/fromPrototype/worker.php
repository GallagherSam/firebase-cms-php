<?php

// Builds the config file that the other files consume

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Get service account
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/google-service-account.json');

// Create firebase instance
$firebase = (new Factory)->withServiceAccount($serviceAccount)->create();

// Create database instance
$database = $firebase->getDatabase();

// Get the site ID from the site-config.json
$siteConfig = json_decode(file_get_contents("site-config.json"));

$ref = $database->getReference($siteConfig->siteId);

$firebaseString = $ref->getSnapshot()->getValue();

$fp = fopen('site-data.json', 'w');
fwrite($fp, json_encode($firebaseString));
fclose($fp);

?>