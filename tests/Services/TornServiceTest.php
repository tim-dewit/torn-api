<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Client;
use Torn\Services\AbstractService;
use Torn\Services\TornService;

/**
 * @coversDefaultClass TornService
 */
class TornServiceTest extends TestCase
{
    /**
     * @covers ::construct
     */
    public function testInheritance()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new TornService($clientMock);

        $this->assertInstanceOf(AbstractService::class, $userService);
    }
}
