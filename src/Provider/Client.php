<?php

namespace Webmacaj\Nominatim\Provider;

use GuzzleHttp\Client as Http;

/**
 * Http Client wrapper.
 */
class Client
{
    /** @var string */
    protected $_endpoint = 'https://nominatim.openstreetmap.org/';

    /** @var Http */
    protected $_client;

    /**
     * Client constructor.
     */
    public function __construct(string $format)
    {
        $this->_client = new Http([
            'base_uri' => $this->_endpoint,
            'headers' => [
                'Accept-Encoding' => 'gzip, deflate'
            ]
        ]);

        $this->_format = $format;
    }

    /**
     * Execute an request to nominatim endpoint.
     *
     * @param string $path
     * @param array $queryData
     *
     * @return string|bool Response string or false on failure. Errors can be retrieved by calling Client::getErrors().
     */
    public function request(string $path, array $queryData)
    {
        $queryData += ['format' => $this->_format, 'addressdetails' => 1];

        try {
            $response = $this->_client->get(\ltrim($path, '/'), [
                'query' => $queryData
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return false;
        }

        if (!\in_array($response->getStatusCode(), [200, 201, 202])) {
            return false;
        }

        $body = $response->getBody();

        if (!$body->getSize()) {
            return false;
        }

        return $response->getBody()->getContents();
    }

    /**
     * Endpoint setter.
     *
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint)
    {
        $this->_endpoint = rtrim('/', $endpoint) . '/';
    }
}