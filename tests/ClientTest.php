<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Torn\Client;
use Torn\Exceptions\TornException;

/**
 * @coversDefaultClass Client
 */
class ClientTest extends TestCase
{
    const MASTER_API_KEY = 'foo';

    /**
     * @covers ::makeRequest
     */
    public function testMakeRequest()
    {
        $resource = 'someResource';
        $selections = ['foo', 'bar'];
        $responseMock = $this->createResponseMock();
        $httpClientSpy = $this->createMock(GuzzleClient::class);
        $httpClientSpy->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                $this->equalTo(Client::TORN_API_BASE_URL . $resource),
                $this->equalTo(
                    [
                        'query' =>
                            [
                                'selections' => implode(',', $selections),
                                'key' => self::MASTER_API_KEY,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy);
        $client->makeRequest($resource, $selections, self::MASTER_API_KEY);
    }

    /**
     * @covers ::makeRequest
     */
    public function testMakeRequestFallsBackToMasterKey()
    {
        $responseMock = $this->createResponseMock();
        $httpClientSpy = $this->createMock(GuzzleClient::class);
        $httpClientSpy->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                $this->anything(),
                $this->equalTo(
                    [
                        'query' =>
                            [
                                'selections' => '',
                                'key' => self::MASTER_API_KEY,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy, self::MASTER_API_KEY);
        $client->makeRequest('');
    }

    /**
     * @covers ::makeRequest
     */
    public function testMakeRequestThrowsException()
    {
        $responsePayload = [
            'error' => [
                'code' => 0,
                'error' => 'Some error message',
            ],
        ];
        $responseBodyMock = $this->createMock(StreamInterface::class);
        $responseBodyMock->method('getContents')->willReturn(json_encode($responsePayload));
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($responseBodyMock);
        $httpClientMock = $this->createMock(GuzzleClient::class);
        $httpClientMock->method('request')->willReturn($responseMock);

        $this->expectException(TornException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Some error message');

        $client = new Client($httpClientMock);
        $client->makeRequest('');
    }

    /**
     * @covers ::shouldUseTornProxy
     */
    public function testShouldUseTornProxyDefaultsToFalse()
    {
        $client = $this->createClient();

        $this->assertFalse($client->shouldUseTornProxy());
    }

    /**
     * @covers ::shouldUseTornProxy
     * @covers ::setShouldUseTornProxy
     */
    public function testSetShouldUseTornProxy()
    {
        $client = $this->createClient();
        $client->setShouldUseTornProxy(true);

        $this->assertTrue($client->shouldUseTornProxy());
    }

    /**
     * @covers ::__construct
     * @covers ::shouldUseTornProxy
     */
    public function testSettingShouldUseTornProxyViaConstructor()
    {
        $httpClientMock = $this->createMock(GuzzleClient::class);
        $client = new Client(
            $httpClientMock,
            self::MASTER_API_KEY,
            true
        );

        $this->assertTrue($client->shouldUseTornProxy());
    }

    /**
     * @covers ::makeRequest
     */
    public function testMakeRequestAdheresToTheShouldUseTornProxyFlag()
    {
        $resource = '';
        $selections = ['foo', 'bar'];
        $responseMock = $this->createResponseMock();
        $httpClientSpy = $this->createMock(GuzzleClient::class);
        $httpClientSpy->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                $this->equalTo(Client::TORN_PROXY_BASE_URL),
                $this->equalTo(
                    [
                        'query' =>
                            [
                                'selections' => implode(',', $selections),
                                'key' => self::MASTER_API_KEY,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy, self::MASTER_API_KEY, true);
        $client->makeRequest($resource, $selections);
    }

    /**
     * @covers ::makeRequest
     */
    public function testForceUseTornProxyInMakeRequest()
    {
        $resource = '';
        $selections = ['foo', 'bar'];
        $responseMock = $this->createResponseMock();
        $httpClientSpy = $this->createMock(GuzzleClient::class);
        $httpClientSpy->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                $this->equalTo(Client::TORN_PROXY_BASE_URL),
                $this->equalTo(
                    [
                        'query' =>
                            [
                                'selections' => implode(',', $selections),
                                'key' => self::MASTER_API_KEY,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy, self::MASTER_API_KEY, false);
        $client->makeRequest($resource, $selections, self::MASTER_API_KEY, true);
    }

    private function createClient(): Client
    {
        $httpClientMock = $this->createMock(GuzzleClient::class);
        $client = new Client($httpClientMock, self::MASTER_API_KEY);

        return $client;
    }

    private function createResponseMock(): MockObject
    {
        $responseBodyMock = $this->createMock(StreamInterface::class);
        $responseBodyMock->method('getContents')->willReturn('{}');
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($responseBodyMock);

        return $responseMock;
    }
}
