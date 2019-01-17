<?php
/**
 * DatParserTest.php
 *
 * @date        16/11/2018
 * @file        DatParserTest.php
 */

namespace NagiosDat;

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
    const PROGRAMS = 'programstatus';

    /**
     * @var array
     */
    protected $sectionTypes = [
        self::HOSTS,
        self::SERVICES,
        self::PROGRAMS,
    ];


    /**
     * DatParser constructor.
     *
     * @param DatIterator $iterator
     */
    public function __construct(DatIterator $iterator = null)
    {
        if (isset($iterator)) {
            $this->setIterator($iterator);
        }
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
        $programStatus = [];

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
                } elseif ($sectionType == self::PROGRAMS) {
                    $programStatus = $section;
                }

                $sectionType = '';
                $section = [];

                continue;
            }


            $key = substr($line, 0, strpos($line, "="));
            $value = substr($line, strpos($line, "=") + 1);

            if (in_array($sectionType, $this->sectionTypes)) {

                if(substr($value, 0, 1) == "{"){
                    $value = json_decode($value);
                }

                $section[$key] = $value;
            }
        }

        return [
            "machines" => $hostStatus,
            "services" => $serviceStatus,
            "program"  => $programStatus,
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
