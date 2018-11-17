<?php

use NagiosDat\DatIterator;
use NagiosDat\DatParser;

include "vendor/autoload.php";

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$statusFile = "nagios/status.dat";

$datIterator = new DatIterator($statusFile);
$datParser = new DatParser($datIterator);

header("Content-type: application/json");


echo(json_encode($datParser->toArray()));