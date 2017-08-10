<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Client;
use Tarantool\Client\{
    Command\Ping,
    LazyClient,
    Negotiation\Authentication,
    Simple
};
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    FakeConnector
};

final class LazyClientTest extends TestCase
{
    /** @test */
    public function it_is_valid_closure()
    {
        // Mock
        $decorated = new Simple(
            new FakeConnector(),
            [new Authentication('username', 'password')]
        );

        $closure = function () use ($decorated) {
            return $decorated;
        };
        $client = new LazyClient($closure);

        // Execute
        $getClientMethod = function () {
            return $this->getClient();
        };
        $clientFromClosure = $getClientMethod->call($client);

        // Verify
        self::assertInstanceOf(Client::class, $clientFromClosure);
        self::assertSame($decorated, $clientFromClosure);

        $response = $client->request(new Ping());

        self::assertSame([], $response->get());

        self::assertTrue($client->hasSession());

        $session = $client->getSession();
        $client->createSession($session);
        $client->destroySession();

        self::assertFalse($client->hasSession());
    }
}
