<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Client;
use Torn\Services\AbstractService;

class AbstractServiceTest extends TestCase
{
    public function testFetch()
    {
        $resourceName = 'someResource';
        $resourceId = 'someId';
        $clientSpy = $this->createMock(Client::class);
        $clientSpy->expects($this->once())
            ->method('makeRequest')
            ->with(
                $this->equalTo($resourceName . '/' . $resourceId),
                $this->anything(),
                $this->anything()
            );

        $service = new class($clientSpy) extends AbstractService {
            protected $resourceName = 'someResource';
        };
        $service->fetch($resourceId);
    }
}
