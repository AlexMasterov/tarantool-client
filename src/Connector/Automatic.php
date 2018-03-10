<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Closure;
use Tarantool\Connector\{
    Connection,
    Sensor
};
use Tarantool\{
    Connector,
    Protocol\Greeting,
    Protocol\MessagePack,
    Protocol\Request
};

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
                $greeting = $this->connection->receive(Greeting::SIZE);
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

        $binary = $this->connection->receive(Request::PACKET_LENGTH_BYTES);
        $unpacked = $this->packer->unpack($binary);

        $binary = $this->connection->receive($unpacked);
        $unpacked = $this->packer->unpack($binary);

        return $unpacked;
    }
}
