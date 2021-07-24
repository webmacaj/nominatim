<?php

namespace Webmacaj\Nominatim;

class NominatimApi
{
    /**
     * Output format of retrieved data.
     *
     * @var string
     */
    protected $_outputFormat;

    /**
     * NominatimApi constructor.
     *
     * @param string $outputFormat Output format of retrieved data. Allowed options: [xml|json|jsonv2|geojson|geocodejson]. Default: json
     */
    public function __construct(string $outputFormat = 'json')
    {
        $this->_outputFormat = $outputFormat;
    }

    /**
     * Search location by string query.
     *
     * @param string $query
     *
     * @return array
     */
    public function search(string $query)
    {

    }

    /**
     * Search location by structured data
     *
     * @param array<string, string|int> $data Structured lookup data. Accepted keys: [street|city|county|state|country|postalcode]
     */
    public function searchStructured(array $data)
    {

    }

    public function reverse()
    {

    }

    public function lookup()
    {

    }

    public function status()
    {

    }

    public function deletable()
    {

    }

    public function polygons()
    {

    }

    public function details()
    {

    }

    /**
     * Output format getter.
     *
     * @return string
     */
    public function getOutputFormat(): string
    {
        return $this->_outputFormat;
    }

    /**
     * Output format setter.
     *
     * @param string $outputFormat
     */
    public function setOutputFormat(string $outputFormat): void
    {
        $this->_outputFormat = $outputFormat;
    }
}