# Nagios Dat parser


```
$statusFile = "nagios/status.dat";

$datIterator = new DatIterator($statusFile);
$datParser = new DatParser($datIterator);

header("Content-type: application/json");


echo(json_encode($datParser->toArray()));
```