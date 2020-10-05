<?php

declare(strict_types=1);

namespace Torn;

use Torn\Exceptions\ExceptionFactory;
use Torn\Exceptions\TornException;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    const TORN_API_BASE_URL = 'https://api.torn.com/';
    const TORN_PROXY_BASE_URL = 'https://torn-proxy.com/';
    const REQUEST_GET = 'GET';

    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $masterApiKey;

    /**
     * @var bool
     */
    private $shouldUseTornProxy;

    public function __construct(
        \GuzzleHttp\Client $httpClient,
        string $masterApiKey = '',
        bool $shouldUseTornProxy = false
    ) {
        $this->httpClient = $httpClient;
        $this->masterApiKey = $masterApiKey;
        $this->shouldUseTornProxy = $shouldUseTornProxy;
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

    public function shouldUseTornProxy(): bool
    {
        return $this->shouldUseTornProxy;
    }

    public function setShouldUseTornProxy(bool $shouldUseTornProxy)
    {
        $this->shouldUseTornProxy = $shouldUseTornProxy;
    }
}
