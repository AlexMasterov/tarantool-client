<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Tarantool\Connector\{
    MessagePack,
    Request
};

final class FakeMessagePack implements MessagePack
{
    public function __construct(
        array $header = [],
        array $body = []
    ) {
        $this->header = $header;
        $this->body = $body;
    }

    public function pack(Request $request): string
    {
        return 'ce000000088200000100810102';
    }

    public function unpack(string $data): array
    {
        return [
            [],
            [],
        ];
    }
}
