<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Tarantool\Client\Session\CanDecoratedSession;
use Tarantool\{
    Client,
    Computation\Result,
    Protocol\Request,
    Protocol\Response
};

final class PureClient implements Client
{
    use CanDecoratedSession;

    public function __construct(Client $client)
    {
        $this->decoratedClient = $client;
    }

    public function request(Request $request): Response
    {
        return Result::of($request)
            ->map(function ($request) {
                return $this->decoratedClient->request($request);
            });
    }
}
