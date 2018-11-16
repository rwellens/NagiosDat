<?php

use Dat2Json\DatIterator;
use Dat2Json\DatParser;

include "vendor/autoload.php";

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$statusFile = "nagios/status.dat";

$datIterator = new DatIterator($statusFile);
$datParser = new DatParser($datIterator);

var_dump($datParser->toArray());