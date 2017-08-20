<?php
declare(strict_types=1);

namespace Tarantool\TestSuite\Protocol;

use Tarantool\Protocol\Request;

final class FakeRequest implements Request
{
    public function __construct(
        array $header = [],
        array $body = []
    ) {
        $this->header = $header;
        $this->body = $body;
    }

    public function header(): array
    {
        return $this->header;
    }

    public function body(): array
    {
        return $this->body;
    }
}
