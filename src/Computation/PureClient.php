<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Tarantool\{
    Client,
    Client\Command,
    Client\Response,
    Computation\Result
};

final class PureClient implements Client
{
    /** @var Client */
    private $decoratedClient;

    public function __construct(Client $client)
    {
        $this->decoratedClient = $client;
    }

    public function request(Command $command): Response
    {
        return Result::of($command)
            ->map(function ($command) {
                return $this->decoratedClient->request($command);
            });
    }
}
