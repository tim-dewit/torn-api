<?php

declare(strict_types=1);

namespace Torn\Exceptions;

class ExceptionFactory
{
    const EMPTY_KEY_ERROR = 1;
    const INVALID_KEY_ERROR = 2;
    const WRONG_TYPE_ERROR = 3;
    const WRONG_FIELDS_ERROR = 4;
    const TOO_MANY_REQUESTS_ERROR = 5;
    const INCORRECT_ID_ERROR = 6;
    const INCORRECT_ID_ENTITY_RELATION_ERROR = 7;
    const IP_BLOCK_ERROR = 8;
    const API_DISABLED_ERROR = 9;
    const KEY_OWNER_IN_FEDERAL_JAIL_ERROR = 10;
    const KEY_CHANGE_ERROR = 11;
    const KEY_READ_ERROR = 12;

    const EXCEPTION_MAP = [
        self::EMPTY_KEY_ERROR => ApiKeyException::class,
        self::INVALID_KEY_ERROR => ApiKeyException::class,
        self::WRONG_TYPE_ERROR => WrongTypeException::class,
        self::WRONG_FIELDS_ERROR => WrongFieldsException::class,
        self::TOO_MANY_REQUESTS_ERROR => TooManyRequestsException::class,
        self::INCORRECT_ID_ERROR => IncorrectIdException::class,
        self::INCORRECT_ID_ENTITY_RELATION_ERROR => ForbiddenSelectionException::class,
        self::IP_BLOCK_ERROR => IpAddressBlockedException::class,
        self::API_DISABLED_ERROR => ApiDisabledException::class,
        self::KEY_OWNER_IN_FEDERAL_JAIL_ERROR => KeyOwnerBannedException::class,
        self::KEY_CHANGE_ERROR => KeyChangeException::class,
        self::KEY_READ_ERROR => KeyReadException::class
    ];

    public static function fromResponse(array $response): TornException
    {
        $code = $response['error']['code'];
        $message = $response['error']['error'];
        $exceptionClassName = self::EXCEPTION_MAP[$code] ?? TornException::class;

        return new $exceptionClassName($message, $code);
    }
}
