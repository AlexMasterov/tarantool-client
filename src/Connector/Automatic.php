<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector;
use Tarantool\Connector\{
    Connection,
    MessagePack,
    Request,
    Sensor
};
use const Tarantool\Protocol\{
    GREETING_SIZE,
    PACKET_LENGTH_BYTES
};
use function Tarantool\Protocol\unpack_length;

final class Automatic implements Connector
{
    /** @var Connection */
    private $connection;

    /** @var MessagePack */
    private $packer;

    /** @var Sensor */
    private $sensor;

    public function __construct(
        Connection $connection,
        MessagePack $packer,
        Sensor $sensor
    ) {
        $this->connection = $connection;
        $this->packer = $packer;
        $this->sensor = $sensor;

        $this->connection->on('open', function () {
            $this->on('connect', function () {
                $greeting = $this->connection->receive(GREETING_SIZE);
                $this->sensor->emit('greeting', $greeting);
            });
            $this->sensor->emit('connect');
        });
    }

    public function on(string $event, Closure $listener): void
    {
        $this->sensor->on($event, $listener);
    }

    public function off(string $event, Closure $listener): void
    {
        $this->sensor->off($event, $listener);
    }

    public function disconnect(): void
    {
        $this->connection->close();
        $this->sensor->emit('disconnect');
    }

    public function sendRequest(Request $request): array
    {
        $packed = $this->packer->pack($request);

        $this->connection->send($packed);

        $binary = $this->connection->receive(PACKET_LENGTH_BYTES);
        $binary = $this->connection->receive(unpack_length($binary));

        $unpacked = $this->packer->unpack($binary);

        return $unpacked;
    }
}
