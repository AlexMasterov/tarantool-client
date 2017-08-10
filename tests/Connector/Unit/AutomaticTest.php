<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Automatic;
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    FakeMessagePack,
    FakeRequest,
    SpyLogger
};

final class AutomaticTest extends TestCase
{
    /** @test */
    public function it_communicate_successful()
    {
        // Stub
        $connection = new FakeConnection();
        $connector = new Automatic(
            $connection,
            new FakeMessagePack()
        );

        // Spy
        $logger = new SpyLogger();
        $logger->logSignal($connector, ['connect', 'greeting', 'disconnect']);

        // Execute
        $connection->open();
        $connector->sendRequest(new FakeRequest());
        $connector->disconnect();

        // Verify
        self::assertSame(
            ['connect', 'greeting', 'disconnect'],
            $logger->journal()
        );
    }
}
