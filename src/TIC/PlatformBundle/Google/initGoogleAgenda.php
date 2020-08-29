<?php

require_once "../../../../vendor/autoload.php";

require_once "GoogleCalendar.php";

if (php_sapi_name() != 'cli') {
    throw new \Exception('This application must be run on the command line.');
}

$google = new \TIC\PlatformBundle\Google\GoogleCalendar();
$google->getClient(true);