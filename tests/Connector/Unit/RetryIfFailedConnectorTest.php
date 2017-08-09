<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector;
use Tarantool\Connector\Tests\Stub\FakeRequest;
use Tarantool\Connector\{
    Connection\ConnectionException,
    Request,
    RetryIfFailedConnector
};

final class RetryIfFailedConnectorTest extends TestCase
{
    /** @test */
    public function it_does_not_retry_when_successful()
    {
        $retryCount = 3;

        // Mock
        $decorated = self::createMock(Connector::class);
        $request = self::createMock(Request::class);

        // Verify
        $decorated
            ->expects(self::once())
            ->method('listen');

        $decorated
            ->expects(self::once())
            ->method('sendRequest')
            ->will(self::returnValue([]));

        $decorated
            ->expects(self::once())
            ->method('disconnect');

        // Execute
        $connector = $this->newConnector($decorated, $retryCount);
        $connector->listen('greeting', function () {
        });
        $connector->sendRequest($this->newRequest());
        $connector->disconnect();
    }

    /** @test */
    public function it_retries_once_when_only_first_time_fails()
    {
        $retryCount = 3;

        // Mock
        $decorated = self::createMock(Connector::class);

        // Verify
        $decorated
            ->expects(self::at(0))
            ->method('sendRequest')
            ->willThrowException(new ConnectionException());

        $decorated
            ->expects(self::at(1))
            ->method('sendRequest')
            ->will(self::returnValue([]));

        // Execute
        $connector = $this->newConnector($decorated, $retryCount);
        $connector->sendRequest($this->newRequest());
    }

    /** @test */
    public function it_retries_once_when_first_two_times_fail()
    {
        $retryCount = 3;

        // Mock
        $decorated = self::createMock(Connector::class);

        $decorated
            ->expects(self::at(0))
            ->method('sendRequest')
            ->will(self::returnValue([]))
            ->willThrowException(new ConnectionException());

        $decorated
            ->expects(self::at(1))
            ->method('sendRequest')
            ->will(self::returnValue([]))
            ->willThrowException(new ConnectionException());

        $decorated
            ->expects(self::at(2))
            ->method('sendRequest')
            ->will(self::returnValue([]));

        // Execute
        $connector = $this->newConnector($decorated, $retryCount);
        $connector->sendRequest($this->newRequest());
    }

    /** @test */
    public function it_throws_the_last_exception_when_last_retry_fails()
    {
        self::expectException(ConnectionException::class);

        $retryCount = 3;

        // Mock
        $decorated = self::createMock(Connector::class);

        // Verify
        $decorated
            ->expects(self::at(0))
            ->method('sendRequest')
            ->will(self::returnValue([]))
            ->willThrowException(new ConnectionException());

        $decorated
            ->expects(self::at(1))
            ->method('sendRequest')
            ->will(self::returnValue([]))
            ->willThrowException(new ConnectionException());

        $decorated
            ->expects(self::at(2))
            ->method('sendRequest')
            ->will(self::returnValue([]))
            ->willThrowException(new ConnectionException());

        // Execute
        $connector = $this->newConnector($decorated, $retryCount);
        $connector->sendRequest($this->newRequest());
    }

    private function newConnector(...$arguments): Connector
    {
        return new RetryIfFailedConnector(...$arguments);
    }

    private function newRequest(...$arguments): Request
    {
        return new FakeRequest(...$arguments);
    }
}
