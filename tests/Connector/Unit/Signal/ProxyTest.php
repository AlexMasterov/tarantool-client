<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Signal;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector;
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    FakeConnector
};
use Tarantool\Connector\Tests\Unit\Signal\CanNewCounter;
use Tarantool\Connector\{
    Connection,
    Signal,
    Signal\Proxy
};

final class ProxyTest extends TestCase
{
    use CanNewCounter;

    /** @test */
    public function it_is_working_signal()
    {
        // Stub
        $counter = $this->newCounter(0);

        $connection = $this->newFakeConnection();
        $connector = $this->newFakeConnector(
            null, // Connection
            null, // MessagePack
            $this->newSignal(
                $connection,
                ['open' => []] // has the same signal
            )
        );

        // Execute
        $connector->listen('open', function () use ($counter) {
            $counter->increment();
        });

        $connection->open();
        $connection->close();

        // Verify
        self::assertSame(1, $counter->count());
        self::assertSame(1, $counter->count());
    }

    private function newSignal(...$arguments): Signal
    {
        return new Proxy(...$arguments);
    }

    private function newFakeConnection(...$arguments): Connection
    {
        return new FakeConnection(...$arguments);
    }

    private function newFakeConnector(...$arguments): Connector
    {
        return new FakeConnector(...$arguments);
    }
}
