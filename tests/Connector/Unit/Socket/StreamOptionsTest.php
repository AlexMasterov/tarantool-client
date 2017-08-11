<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Connection;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Socket\StreamOptions;

final class StreamOptionsTest extends TestCase
{
    /** @test */
    public function it_is_immutable()
    {
        // Stub
        $options = new StreamOptions();

        // Verify
        $this->assertNotSame($options, $options->withAsync());
        $this->assertNotSame($options, $options->withPersistent());
        $this->assertNotSame($options, $options->withTimeout(10));
        $this->assertNotSame($options, $options->withReadWriteTimeout(3));
        $this->assertNotSame($options, $options->withReadWriteTimeoutMs(200));
        $this->assertNotSame($options, $options->withNoDelay(100));
    }

    /** @test */
    public function it_is_configured_correctly()
    {
        // Stub
        $timeout = 3.0;
        $rwTimeout = 10;
        $rwTimeoutMs = (int) (0.2 * 10e6);
        $noDelay = 200;

        // Execute
        $options = (new StreamOptions())
            ->withTimeout($timeout)
            ->withReadWriteTimeout($rwTimeout)
            ->withReadWriteTimeoutMs($rwTimeoutMs)
            ->withNoDelay($noDelay);

        // Verify
        self::assertSame($timeout, $options->timeout());
        self::assertSame($rwTimeout, $options->readWriteTimeout());
        self::assertSame($rwTimeoutMs, $options->readWriteTimeoutMs());
        self::assertSame($noDelay, $options->noDelay());
        self::assertTrue($options->hasNoDelay());
    }

    /**
     * @test
     * @dataProvider flagsData
     */
    public function it_configures_flags_correctly(array $methods, int $expected)
    {
        // Stub
        $options = new StreamOptions();

        // Execute
        foreach ($methods as $method) {
            $options = $options->{$method}();
        }

        // Verify
        self::assertSame($expected, $options->flags());
    }

    public function flagsData()
    {
        static $default = STREAM_CLIENT_CONNECT;

        return [
            [
                ['withAsync'],
                $default | STREAM_CLIENT_ASYNC_CONNECT,
            ],
            [
                ['withPersistent'],
                $default | STREAM_CLIENT_PERSISTENT,
            ],
            [
                ['withAsync', 'withPersistent'],
                $default | STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_PERSISTENT,
            ],
            [
                ['withAsync', 'withPersistent', 'withPersistent'],
                $default | STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_PERSISTENT,
            ],
        ];
    }
}
