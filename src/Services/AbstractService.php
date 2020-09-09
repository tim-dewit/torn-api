<?php

declare(strict_types=1);

namespace Torn\Services;

use GuzzleHttp\Exception\GuzzleException;
use Torn\Client;
use Torn\Exceptions\TornException;

abstract class AbstractService
{
    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws TornException
     */
    public function fetch(string $resourceId, array $selections = [], string $apiKey = null): array
    {
        $resource = $this->resourceName . '/' . $resourceId;

        return $this->client->makeRequest($resource, $selections, $apiKey);
    }
}
