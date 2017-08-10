<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Client\{
    ClientException,
    Command\Ping,
    Negotiation\Authentication,
    Simple
};
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    FakeConnector
};

final class SimpleTest extends TestCase
{
    /** @test */
    public function it_request_successful()
    {
        // Mock
        $client = new Simple(
            new FakeConnector(),
            [new Authentication('username', 'password')]
        );

        // Execute
        $response = $client->request(new Ping());

        // Verify
        self::assertSame([], $response->get());
    }

    /** @test */
    public function it_destroy_session_successful()
    {
        // Verify
        self::expectException(ClientException::class);
        self::expectExceptionCode(ClientException::SESSION_NOT_FOUND);

        // Stub
        $client = new Simple(
            new FakeConnector(),
            [new Authentication('username', 'password')]
        );

        // Execute
        $client->request(new Ping());
        $client->destroySession();
        $client->getSession();
    }
}
