<?php
declare(strict_types=1);

namespace Tarantool\Connector;

function pack_length(int $length): string
{
    return \pack('CN', 0xce, $length);
}

function unpack_length(string $data): int
{
    ['length' => $length] = \unpack('C_/Nlength', $data);

    return $length;
}
