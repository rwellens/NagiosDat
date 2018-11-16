<?php
/**
 * DatParser.php
 *
 * @date        16/11/2018
 * @file        DatParser.php
 */

namespace Dat2Json;

/**
 * Class DatParser
 */
class DatParser
{
    /**
     * @var DatIterator
     */
    protected $iterator;

    const SERVICES = 'servicestatus';
    const HOSTS = 'hoststatus';
    const PROGRAMS = 'programstatus'; // not used

    /**
     * @var array
     */
    protected $sectionTypes = [self::HOSTS, self::SERVICES, self::PROGRAMS];


    /**
     * DatParser constructor.
     *
     * @param DatIterator $iterator
     */
    public function __construct(DatIterator $iterator = null)
    {
        $this->iterator = $iterator;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $sectionType = '';

        $section = [];
        $serviceStatus = [];
        $hostStatus = [];

        foreach ($this->getIterator()->parse() as $line) {
            if (substr($line, strlen($line) - 1, 1) == "{") {
                $sectionType = substr($line, 0, strpos($line, " "));
                continue;
            }

            if ($line == "}") {
                $sections[$sectionType] = $section;

                if ($sectionType == self::SERVICES) {
                    $serviceStatus[$section['host_name']][$section['service_description']] = $section;
                } elseif ($sectionType == self::HOSTS) {
                    $hostStatus[$section["host_name"]] = $section;
                }

                $sectionType = '';
                $section = [];

                continue;
            }

            $key = substr($line, 0, strpos($line, "="));
            $value = substr($line, strpos($line, "=") + 1);

            if (in_array($sectionType, $this->sectionTypes)) {
                $section[$key] = $value;
            }
        }

        return [
            "machines" => $hostStatus,
            "services" => $serviceStatus,
        ];
    }

    /**
     * @return DatIterator
     */
    public function getIterator(): DatIterator
    {
        if (!$this->iterator) {
            throw Exception::noIteratorDefined();
        }

        return $this->iterator;
    }

    /**
     * @param DatIterator $iterator
     *
     * @return $this
     */
    public function setIterator(DatIterator $iterator)
    {
        $this->iterator = $iterator;

        return $this;
    }
}
