<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

final class SyncRequest implements Request
{
    /** @var Request */
    private $synchronizedRequest;

    /** @var int */
    private $value;

    public function __construct(
        Request $request,
        int $value = 0
    ) {
        $this->synchronizedRequest = $request;
        $this->value = $value;
    }

    public function header(): array
    {
        return [
            self::SYNC => $this->value,
        ] + $this->synchronizedRequest->header();
    }

    public function body(): array
    {
        return $this->synchronizedRequest->body();
    }

    public function sync(): int
    {
        return $this->value;
    }
}
