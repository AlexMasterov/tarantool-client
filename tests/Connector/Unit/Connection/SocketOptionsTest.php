<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Connection;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Connection\SocketOptions;

final class SocketOptionsTest extends TestCase
{
    /** @test */
    public function it_is_immutability()
    {
        // Stub
        $options = $this->socketOptions();

        // Verify
        $this->assertNotSame($options, $options->withAsync());
        $this->assertNotSame($options, $options->withPersistent());
        $this->assertNotSame($options, $options->withTimeout(10));
        $this->assertNotSame($options, $options->withReadWriteTimeoutSeconds(3));
        $this->assertNotSame($options, $options->withReadWriteTimeoutMicroseconds(200));
        $this->assertNotSame($options, $options->withNoDelay(100));
    }

    /** @test */
    public function it_valid_configure()
    {
        // Stub
        $timeout = 3.0;
        $rwTimeoutSeconds = 10;
        $rwTimeoutMicroseconds = (int) (0.2 * 10e6);
        $noDelay = 200;

        // Execute
        $options = $this->socketOptions()
            ->withTimeout($timeout)
            ->withReadWriteTimeoutSeconds($rwTimeoutSeconds)
            ->withReadWriteTimeoutMicroseconds($rwTimeoutMicroseconds)
            ->withNoDelay($noDelay);

        // Verify
        self::assertSame($timeout, $options->timeout());
        self::assertSame($rwTimeoutSeconds, $options->readWriteTimeoutSeconds());
        self::assertSame($rwTimeoutMicroseconds, $options->readWriteTimeoutMicroseconds());
        self::assertSame($noDelay, $options->noDelay());
    }

    /**
     * @test
     * @dataProvider flagsData
     */
    public function it_valid_configure_flags(array $methods, int $expected)
    {
        // Stub
        $options = $this->socketOptions();

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

    private function socketOptions(): SocketOptions
    {
        return new SocketOptions();
    }
}
