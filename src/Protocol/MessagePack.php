<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

use Tarantool\Protocol\Request;

interface MessagePack
{
    public function pack(Request $request): string;

    public function unpack(string $data);
}
