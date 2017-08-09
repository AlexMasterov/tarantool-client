<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Closure;
use Tarantool\Client;
use Tarantool\Client\{
    Command,
    Response,
    Session\CanDecoratedSession
};

final class LazyClient implements Client
{
    use CanDecoratedSession;

    /** @param Closure */
    private $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function request(Command $command): Response
    {
        return $this->getClient()->sendRequest($command);
    }

    private function getClient(): Client
    {
        return $this->decoratedClient
            ?? $this->decoratedClient = ($this->closure)();
    }
}
