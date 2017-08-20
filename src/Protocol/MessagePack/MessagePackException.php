<?php
declare(strict_types=1);

namespace Tarantool\Protocol\MessagePack;

use RuntimeException;
use Tarantool\TarantoolException;

final class MessagePackException extends RuntimeException implements TarantoolException
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
