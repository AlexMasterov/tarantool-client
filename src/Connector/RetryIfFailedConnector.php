<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector;
use Tarantool\Connector\{
    Connection\ConnectionException,
    Request,
    Sensor\CanDecoratedListen
};

final class RetryIfFailedConnector implements Connector
{
    use CanDecoratedListen;

    /** @var Connector */
    private $decoratedConnector;

    /** @var int */
    private $retryCount;

    public function __construct(Connector $connector, int $retryCount)
    {
        $this->decoratedConnector = $connector;
        $this->retryCount = $retryCount;
    }

    public function disconnect(): void
    {
        $this->decoratedConnector->disconnect();
    }

    public function sendRequest(Request $request): array
    {
        for ($i = 0; $i < $this->retryCount; $i += 1) {
            try {
                return $this->decoratedConnector->sendRequest($request);
            } catch (ConnectionException $e) {
            }
        }

        throw new ConnectionException('Cannot send request, connection failed');
    }
}
