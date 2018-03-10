<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use DateInterval;
use InvalidArgumentException;
use Tarantool\Connector;
use Tarantool\Connector\{
    Automatic,
    Connection,
    Connection\AutomaticConnection,
    Connection\StreamSocket,
    RetryIfFailedConnector,
    Sensor\Standart as StandartSensor,
    Socket\StreamFactory,
    Socket\StreamOptions
};
use Tarantool\Protocol\MessagePack\Standart as StandartPacker;

final class Factory
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

        if (!\in_array($components['scheme'], ['tcp', 'unix'])) {
            throw new InvalidArgumentException('Use tcp:// or unix://');
        }

        ['scheme' => $scheme, 'host' => $host] = $components;

        if ('tcp' === $scheme) {
            $port = $components['port'] ?? 3301;
            $host = "{$host}:{$port}";
        }

        $url = "{$scheme}://{$host}";
        $query = [];

        if (isset($components['query'])) {
            \parse_str($components['query'], $query);
        }

        $options = self::streamOptions($query);

        $connection = new StreamSocket(
            $url,
            new StreamFactory($options),
            new StandartSensor()
        );

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
            new StandartPacker(),
            new StandartSensor()
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

    private static function streamOptions(array $query = []): StreamOptions
    {
        $timeout = (float) ($query['timeout'] ?? 3);
        $options = new StreamOptions($timeout);

        if (empty($query)) {
            return $options;
        }

        if (isset($query['rwTimeout'])) {
            $rwTimeout = (int) $query['rwTimeout'];
            $options = $options->withReadWriteTimeout($rwTimeout);
        }

        if (isset($query['rwTimeoutMs'])) {
            $rwTimeoutMs = (int) $query['rwTimeoutMs'];
            $options = $options->withReadWriteTimeoutMs($rwTimeoutMs);
        }

        if (isset($query['noDelay'])) {
            $options = $options->withNoDelay($query['noDelay']);
        }

        return $options;
    }
}
