<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector;
use Tarantool\Connector\{
    Connection,
    MessagePack,
    Request,
    Sensor\CanListen,
    Signal\Standart
};
use function Tarantool\Connector\unpack_length;

final class Automatic implements Connector
{
    use CanListen;

    /** @var Connection */
    private $connection;

    /** @var MessagePack */
    private $packer;

    public function __construct(
        Connection $connection,
        MessagePack $packer,
        Signal $signal = null
    ) {
        $this->connection = $connection;
        $this->packer = $packer;
        $this->signal = $signal ?? new Standart();

        $this->connection->listen('open', function () {
            $this->listen('connect', function () {
                $greeting = $this->connection->receive(Request::GREETING_SIZE);
                $this->signal->beep('greeting', $greeting);
            });
            $this->signal->beep('connect');
        });
    }

    public function disconnect(): void
    {
        $this->connection->close();
        $this->signal->beep('disconnect');
    }

    public function sendRequest(Request $request): array
    {
        $packed = $this->packer->pack($request);

        $this->connection->send($packed);

        $binary = $this->connection->receive(Request::PACKET_LENGTH_BYTES);
        $binary = $this->connection->receive(unpack_length($binary));

        $unpacked = $this->packer->unpack($binary);

        return $unpacked;
    }
}
