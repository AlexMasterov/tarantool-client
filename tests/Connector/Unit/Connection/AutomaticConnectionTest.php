<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Connection;

use DateInterval;
use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Connection\AutomaticConnection;
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    SpyLogger
};

final class AutomaticConnectionTest extends TestCase
{
    /** @test */
    public function it_is_automatic_connect()
    {
        // Stub
        $decorated = new FakeConnection();
        $connection = new AutomaticConnection(
            $decorated,
            new DateInterval('PT3S')
        );

        // Execute
        $connection->send('data');

        // Verify
        self::assertGreaterThan(FakeConnection::CLOSED, $decorated->state());
    }

    /** @test */
    public function it_reconnects_when_time_passed()
    {
        // Stub
        $decorated = new FakeConnection();
        $connection = new AutomaticConnection(
            $decorated,
            new DateInterval('PT0S')
        );

        // Spy
        $logger = new SpyLogger();
        $logger->logSignal($decorated, ['open', 'close', 'receive']);

        // Execute
        $connection->open();
        $connection->receive(42);

        // Verify
        self::assertSame(
            ['open', 'close', 'open', 'receive'],
            $logger->journal()
        );
    }
}
