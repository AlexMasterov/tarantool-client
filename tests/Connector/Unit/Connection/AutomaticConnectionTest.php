<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Connection;

use DateInterval;
use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    State
};
use Tarantool\Connector\{
    Connection,
    Connection\AutomaticConnection
};

final class AutomaticConnectionTest extends TestCase
{
    /** @test */
    public function it_is_automatic_connect()
    {
        // Stub
        $decorated = $this->newFakeConnection();
        $connection = $this->newConnection(
            $decorated,
            new DateInterval('PT0S')
        );

        // Execute
        $connection->listen('open', function () {
        });
        $connection->send('data');

        // Verify
        self::assertSame(State::CONNECTED, $decorated->state());
    }

    private function newConnection(...$arguments): Connection
    {
        return new AutomaticConnection(...$arguments);
    }

    private function newFakeConnection(...$arguments): Connection
    {
        return new FakeConnection(...$arguments);
    }
}
