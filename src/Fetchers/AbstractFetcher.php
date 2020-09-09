<?php

declare(strict_types=1);

namespace Torn\Fetchers;

use GuzzleHttp\Exception\GuzzleException;
use Torn\Client;
use Torn\Exceptions\InvalidSelectionException;
use Torn\Exceptions\TornException;

abstract class AbstractFetcher
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
    public function fetch(string $resourceId, array $selections, string $apiKey = null): array
    {
        $resource = $this->resourceName . '/' . $resourceId;

        return $this->client->makeRequest($resource, $selections, $apiKey);
    }
}
