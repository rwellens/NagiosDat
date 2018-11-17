<?php
/**
 * DatParserTest.php
 *
 * @date        17/11/2018
 * @file        DatIterator.php
 */

namespace NagiosDatTest;

use NagiosDat\DatIterator;
use NagiosDat\DatParser;
use NagiosDat\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class DatIterator
 */
class DatParserTest extends TestCase
{

    public function testStartSectionIsDetected()
    {

        $dataPath = realpath(__DIR__ . '/../_data');
        $iterator = new DatIterator($dataPath . '/status.dat');

        $datParser = new DatParser($iterator);

        $this->assertEquals($datParser->toArray(), json_decode(file_get_contents($dataPath.'/nagiosStatus.json'), true));
    }

    public function testExceptionIfNoIteratorSetted()
    {

        $this->expectException(Exception::class);

        $iterator = new DatParser();
        $iterator->getIterator();
    }


}
