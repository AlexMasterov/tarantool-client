<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\Protocol\{
    Request,
    Request\Call,
    Request\Evaluate,
    Request\Ping,
    Response
};
use Tarantool\{
    Client,
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

    public function request(Request $request): Response
    {
        return $this->client->request($request);
    }

    public function ping(): Response
    {
        $request = new Ping();

        return $this->client->request($request);
    }

    public function call(string $functionName, array $arguments = []): Response
    {
        $request = new Call($functionName, $arguments);

        return $this->client->request($request);
    }

    public function evaluate(string $expression, array $arguments = []): Response
    {
        $request = new Evaluate($expression, $arguments);

        return $this->client->request($request);
    }
}
