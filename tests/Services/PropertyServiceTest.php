<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Services\AbstractService;
use Torn\Services\PropertyService;

/**
 * @coversDefaultClass \Torn\Services\PropertyService
 */
class PropertyServiceTest extends TestCase
{
    /**
     * @covers ::construct
     */
    public function testInheritance()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new PropertyService($clientMock);

        $this->assertInstanceOf(AbstractService::class, $userService);
    }
}
