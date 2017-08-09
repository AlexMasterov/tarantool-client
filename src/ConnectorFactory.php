<?php
declare(strict_types=1);

namespace Tarantool;

use DateInterval;
use InvalidArgumentException;
use Tarantool\Connector;
use Tarantool\Connector\{
    Automatic,
    Connection,
    Connection\AutomaticConnection,
    Connection\SocketOptions,
    Connection\TcpSocket,
    Connection\UnixSocket,
    MessagePack\PurePacker,
    RetryIfFailedConnector
};

final class ConnectorFactory
{
    /** @var Connection */
    private $connection;

    /** @var string */
    private $reconnectAfter = 'PT300S';

    /** @var int */
    private $reconnectMax = 0;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public static function fromString(string $dataSourceName): self
    {
        $components = \parse_url($dataSourceName);

        if (!isset($components['scheme'], $components['host'])) {
            throw new InvalidArgumentException('Scheme and host are required');
        }

        static $query = [];

        if (isset($components['query'])) {
            \parse_str($components['query'], $query);
        }

        $timeout = (float) ($query['timeout'] ?? 3);
        $options = new SocketOptions($timeout);

        if (isset($query['rwTimeout'])) {
            $rwTimeout = (int) $query['rwTimeout'];
            $options = $options->withReadWriteTimeoutSeconds($rwTimeout);
        }

        if (isset($query['rwTimeoutMs'])) {
            $rwTimeoutMs = (int) $query['rwTimeoutMs'];
            $options = $options->withReadWriteTimeoutMicroseconds($rwTimeoutMs);
        }

        if (isset($query['noDelay'])) {
            $options = $options->withNoDelay($query['noDelay']);
        }

        switch ($components['scheme']) {
            case 'tcp':
                $connection = new TcpSocket(
                    $components['host'],
                    $components['port'] ?? 3301,
                    $options
                );
                break;
            case 'unix':
                $connection = new UnixSocket(
                    $components['host'],
                    $options
                );
                break;
            default:
                throw new InvalidArgumentException(
                    'Use tcp:// or unix://'
                );
        }

        $factory = new self($connection);

        if (isset($query['reconnectAfter'])) {
            $factory->reconnectAfter = $query['reconnectAfter'];
        }

        if (isset($query['reconnectMax'])) {
            $factory->reconnectMax = (int) $query['reconnectMax'];
        }

        return $factory;
    }

    public function newConnector(): Connector
    {
        $connector = new Automatic(
            new AutomaticConnection(
                $this->connection,
                new DateInterval($this->reconnectAfter)
            ),
            new PurePacker()
        );

        if ($this->reconnectMax > 0) {
            $connector = new RetryIfFailedConnector(
                $connector,
                $this->reconnectMax
            );
        }

        return $connector;
    }

    public function withReconnectMax(int $retryCount): self
    {
        $clone = clone $this;
        $clone->reconnectMax = $retryCount;

        return $clone;
    }
}
