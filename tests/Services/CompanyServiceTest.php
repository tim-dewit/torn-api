<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Client;
use Torn\Services\AbstractService;
use Torn\Services\CompanyService;

/**
 * @coversDefaultClass CompanyService
 */
class CompanyServiceTest extends TestCase
{
    /**
     * @covers ::construct
     */
    public function testInheritance()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new CompanyService($clientMock);

        $this->assertInstanceOf(AbstractService::class, $userService);
    }
}
