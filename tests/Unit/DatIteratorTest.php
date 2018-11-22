<?php
/**
 * DatIteratorTest.php
 *
 * @date        17/11/2018
 * @file        DatIterator.php
 */

namespace NagiosDatTest;

use NagiosDat\DatIterator;
use PHPUnit\Framework\TestCase;

/**
 * Class DatIterator
 */
class DatIteratorTest extends TestCase
{

    public function testLineIsCleaned()
    {

        $dataPath = realpath(__DIR__ . '/../_data');
        $iterator = new DatIterator($dataPath . '/status.dat');


        foreach ($iterator->parse() as $line) {

            $this->assertStringStartsNotWith('#', $line);
            $this->assertNotEmpty($line);

        }


    }


}
