<?php
declare(strict_types=1);

namespace Tarantool\Connector\MessagePack;

use RuntimeException;
use Tarantool\TarantoolException;
use Exception;

final class MessagePackException extends Exception implements TarantoolException
{
    public const UNABLE_UNPACK = 1;

    public static function unableUnpack(): MessagePackException
    {
        return new static(
            'Unable to unpack data',
            self::UNABLE_UNPACK
        );
    }
}
