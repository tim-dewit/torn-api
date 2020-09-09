<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Client;
use Torn\Exceptions\ApiKeyException;
use Torn\Services\UserService;
use Torn\Services\AbstractService;

/**
 * @coversDefaultClass \Torn\Services\UserService
 */
class UserServiceTest extends TestCase
{
    /**
     * @covers ::construct
     */
    public function testInheritance()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new UserService($clientMock);

        $this->assertInstanceOf(AbstractService::class, $userService);
    }

    /**
     * @covers ::isApiKeyValid
     */
    public function testIsApiKeyValid()
    {
        $clientMock = $this->createMock(Client::class);
        $userService = new UserService($clientMock);

        $this->assertTrue($userService->isApiKeyValid(''));
    }

    /**
     * @covers ::isApiKeyValid
     */
    public function testIsApiKeyValidReturnsFalseOnApiKeyException()
    {
        $clientMock = $this->createMock(Client::class);
        $clientMock->method('makeRequest')
            ->willThrowException(new ApiKeyException());
        $userService = new UserService($clientMock);

        $this->assertFalse($userService->isApiKeyValid(''));
    }
}
