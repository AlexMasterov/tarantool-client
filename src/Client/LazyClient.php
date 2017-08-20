<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Closure;
use Tarantool\Client\Session\CanDecoratedSession;
use Tarantool\{
    Client,
    Connector,
    Protocol\Request,
    Protocol\Response
};

final class LazyClient implements Client
{
    use CanDecoratedSession;

    /** @var Closure */
    private $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function request(Request $request): Response
    {
        return $this->getClient()->request($request);
    }

    private function getClient(): Client
    {
        return $this->decoratedClient
            ?? $this->decoratedClient = ($this->closure)();
    }
}
