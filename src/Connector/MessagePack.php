<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector\Request;

interface MessagePack
{
    public function pack(Request $request): string;

    public function unpack(string $data): array;
}
