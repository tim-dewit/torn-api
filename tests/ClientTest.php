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
    /**
     * @covers ::makeRequest
     */
    public function testMakeRequest()
    {
        $resource = 'someResource';
        $selections = ['foo', 'bar'];
        $apiKey = 'someKey';
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
                                'key' => $apiKey,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy);
        $client->makeRequest($resource, $selections, $apiKey);
    }

    /**
     * @covers ::makeRequest
     */
    public function testMakeRequestFallsBackToMasterKey()
    {
        $masterApiKey = 'someKey';
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
                                'key' => $masterApiKey,
                            ]
                    ]
                )
            )
            ->willReturn($responseMock);

        $client = new Client($httpClientSpy, $masterApiKey);
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

    private function createResponseMock(): MockObject
    {
        $responseBodyMock = $this->createMock(StreamInterface::class);
        $responseBodyMock->method('getContents')->willReturn('{}');
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($responseBodyMock);

        return $responseMock;
    }
}
