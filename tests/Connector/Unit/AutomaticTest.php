<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\{
    CanLoggerSignal,
    FakeConnection,
    FakeMessagePack,
    FakeRequest
};
use Tarantool\Connector\{
    Automatic,
    Connection,
    MessagePack,
    Sensor,
    Signal\Proxy
};

final class AutomaticTest extends TestCase
{
    use CanLoggerSignal;

    /** @test */
    public function it_is_fine_communicate()
    {
        $signals = [
            'connect',
            'greeting',
            'disconnect',
        ];

        // Stub
        $connection = $this->newFakeConnection();
        $connector = new Automatic(
            $connection,
            $this->newFakeMessagePack()
        );

        // Spy
        $logger = $this->logger();
        $this->logSignal($logger, $connector, $signals);

        // Execute
        $connection->open();
        $connector->sendRequest(new FakeRequest());
        $connector->disconnect();

        // Verify
        self::assertSame($signals, $logger->journal());
    }

    private function newFakeConnection(...$arguments): Connection
    {
        return new FakeConnection(...$arguments);
    }

    private function newFakeMessagePack(...$arguments): MessagePack
    {
        return new FakeMessagePack(...$arguments);
    }
}
