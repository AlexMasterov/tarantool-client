<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\Client;
use Tarantool\Client\{
    Command,
    Command\Call,
    Command\Evaluate,
    Command\Ping,
    Response,
    Session
};

final class Tarantool
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getSession(): Session
    {
        $this->client->hasSession() ?: $this->ping();

        return $this->client->getSession();
    }

    public function destroySession(): void
    {
        $this->client->destroySession();
    }

    public function request(Command $command): Response
    {
        return $this->client->request($command);
    }

    public function ping(): Response
    {
        $command = new Ping();

        return $this->client->request($command);
    }

    public function call(string $functionName, array $arguments = []): Response
    {
        $command = new Call($functionName, $arguments);

        return $this->client->request($command);
    }

    public function evaluate(string $expression, array $arguments = []): Response
    {
        $command = new Evaluate($expression, $arguments);

        return $this->client->request($command);
    }
}
