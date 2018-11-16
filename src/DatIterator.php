<?php
/**
 * DatIterator.php
 *
 * @date        16/11/2018
 * @file        DatIterator.php
 */

namespace Dat2Json;

/**
 * Class DatIterator
 */
class DatIterator
{
    /**
     * @var bool|resource
     */
    protected $file;

    /**
     * DatIterator constructor.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = fopen($file, 'r');
    }


    /**
     * remove blank line and comment
     *
     * @return \Generator|void
     */
    public function parse(): ?\Generator
    {
        while ($line = fgets($this->file)) {
            $line = trim($line);

            if ($line == "" or substr($line, 0, 1) == "#") {
                continue;
            }

            yield $line;
        }

        return;
    }
}
