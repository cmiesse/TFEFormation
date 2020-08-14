<?php

require_once "../../../../vendor/autoload.php";

/**
 * Created by PhpStorm.
 * Date: 23-05-16
 * Time: 11:04
 */

require_once "GoogleCalendar.php";

if (php_sapi_name() != 'cli') {
    throw new \Exception('This application must be run on the command line.');
}

$google = new \TIC\PlatformBundle\Google\GoogleCalendar();
$google->getClient(true);