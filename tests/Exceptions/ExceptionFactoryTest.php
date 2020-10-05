<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Torn\Exceptions\ApiDisabledException;
use Torn\Exceptions\ExceptionFactory;

/**
 * @coversDefaultClass ExceptionFactory
 */
class ExceptionFactoryTest extends TestCase
{
    /**
     * @covers ::createFromResponse
     */
    public function testCreateFromResponse()
    {
        $errorMessage = 'foo';
        $responseData = [
            'error' => [
                'code' => ExceptionFactory::API_DISABLED_ERROR,
                'error' => $errorMessage,
            ],
        ];

        $exception = ExceptionFactory::fromResponse($responseData);

        $this->assertInstanceOf(ApiDisabledException::class, $exception);
        $this->assertSame($errorMessage, $exception->getMessage());
    }

    /**
     * @covers ::createFromResponse
     */
    public function testCreateFromResponseWithInvalidTornProxyKey()
    {
        $errorMessage = 'foo';
        $responseData = [
            'error' => [
                'code' => ExceptionFactory::INVALID_KEY_ERROR,
                'error' => 'torn error message',
                'proxy' => true,
                'proxy_code' => ExceptionFactory::PROXY_INVALID_KEY_ERROR,
                'proxy_message' => $errorMessage,
            ],
        ];

        $exception = ExceptionFactory::fromResponse($responseData);

        $this->assertInstanceOf(TornProxyInvalidApiKeyException::class, $exception);
        $this->assertSame($errorMessage, $exception->getMessage());
    }

    /**
     * @covers ::createFromResponse
     */
    public function testCreateFromResponseWithRevokedTornProxyKey()
    {
        $errorMessage = 'foo';
        $responseData = [
            'error' => [
                'code' => ExceptionFactory::INVALID_KEY_ERROR,
                'error' => 'torn error message',
                'proxy' => true,
                'proxy_code' => ExceptionFactory::PROXY_REVOKED_KEY_ERROR,
                'proxy_message' => $errorMessage,
            ],
        ];

        $exception = ExceptionFactory::fromResponse($responseData);

        $this->assertInstanceOf(TornProxyRevokedApiKeyException::class, $exception);
        $this->assertSame($errorMessage, $exception->getMessage());
    }
}
