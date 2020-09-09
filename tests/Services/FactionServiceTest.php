<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Client;
use Torn\Services\AbstractService;
use Torn\Services\FactionService;

/**
 * @coversDefaultClass \Torn\Services\FactionService
 */
class FactionServiceTest extends TestCase
{
    /**
     * @covers ::construct
     */
    public function testInheritance()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new FactionService($clientMock);

        $this->assertInstanceOf(AbstractService::class, $userService);
    }
}
