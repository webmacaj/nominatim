<?php

namespace Webmacaj\Nominatim;

use Webmacaj\Nominatim\Formatter\FormatterInterface;
use Webmacaj\Nominatim\Provider\Client;

class NominatimApi
{
    /**
     * Output format of retrieved data.
     *
     * @var string
     */
    protected $_outputFormat;

    /**
     * Formatter instance.
     *
     * @var FormatterInterface
     */
    protected $_formatter;

    /** @var Client */
    protected $_client;

    /**
     * NominatimApi constructor.
     *
     * @param string $outputFormat Optional. Output format of retrieved data. Allowed options: [xml|json|jsonv2|geojson|geocodejson]. Default: json
     * @param string|null $endpoint Optional. Custom nominatim API endpoint.
     */
    public function __construct(string $outputFormat = 'json', string $endpoint = null)
    {
        $this->_client = new Client($outputFormat);

        if ($endpoint) {
            $this->_client->setEndpoint($endpoint);
        }

        $this->_outputFormat = $outputFormat;
        $formatterClass = 'Webmacaj\Nominatim\Formatter\\' . \ucfirst($outputFormat) . 'Formatter';
        $this->_formatter = new $formatterClass();
    }

    /**
     * Search location by structured or string query.
     *
     * @param array $query Structured lookup data. Accepted keys: [query|street|city|county|state|country|postalcode]
     * If "query" key is used, all other keys will be omitted from request as it is not recommended to combine them.
     *
     * @return array
     */
    public function search(array $query): array
    {
        if (isset($query['query']) && $query['query']) {
            $query = ['q' => $query['query']];
        }

        $response = $this->_client->request('search', $query);

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function reverse(float $lat, float $lon, array $options = []): array
    {
        $response = $this->_client->request('reverse', \array_merge([
            'lat' => $lat,
            'lon' => $lon
        ], $options));

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function addressLookup(array $osmIds, array $options = []): array
    {
        $response = $this->_client->request('lookup', \array_merge([
            'osm_ids' => \implode(',', $osmIds)
        ], $options));

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function details(string $osmType, int $osmId, string $class = null): array
    {
        $requestData = [
            'osm_type' => $osmType,
            'osm_id' => $osmId
        ];

        if ($class) {
            $requestData['class'] = $class;
        }

        $response = $this->_client->request('details', $requestData);

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function placeDetails(int $placeId): array
    {
        $response = $this->_client->request('details', [
            'place_id' => $placeId
        ]);

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function status(): bool
    {
        $response = $this->_client->request('status');

        if (!$response) {
            return false;
        }

        return true;
    }

    public function deletable(): array
    {
        $response = $this->_client->request('deletable');

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
    }

    public function polygons(): array
    {
        $response = $this->_client->request('polygons');

        if (!$response) {
            return [];
        }

        return $this->_processResponse($response);
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

    /**
     * Process API response.
     *
     * @param mixed $response
     *
     * @return array
     */
    protected function _processResponse($response): array
    {
        return $this->_formatter->format($response);
    }
}