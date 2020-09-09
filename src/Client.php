<?php

declare(strict_types=1);

namespace Torn;

use Torn\Exceptions\ExceptionFactory;
use Torn\Exceptions\TornException;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    const TORN_API_BASE_URL = 'https://api.torn.com/';
    const REQUEST_GET = 'GET';

    private $httpClient;
    private $masterApiKey;

    public function __construct(\GuzzleHttp\Client $httpClient, string $masterApiKey = '')
    {
        $this->httpClient = $httpClient;
        $this->masterApiKey = $masterApiKey;
    }

    /**
     * @throws GuzzleException
     * @throws TornException
     */
    public function makeRequest(string $resource, array $selections = [], string $apiKey = null): array
    {
        if (!$apiKey) {
            $apiKey = $this->masterApiKey;
        }

        $parameters = [
            'selections' => implode(',', $selections),
            'key' => $apiKey,
        ];
        $url = self::TORN_API_BASE_URL . $resource;

        $response = $this->httpClient->request(
            self::REQUEST_GET,
            $url,
            ['query' => $parameters]
        );

        $body = json_decode($response->getBody()->getContents(), true);
        if (isset($body['error'])) {
            throw ExceptionFactory::fromResponse($body);
        }

        return $body;
    }
}
