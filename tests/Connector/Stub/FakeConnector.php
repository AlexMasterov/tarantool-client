<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Tarantool\Connector;
use Tarantool\Connector\Tests\Stub\{
    FakeConnection,
    FakeMessagePack
};
use Tarantool\Connector\{
    Connection,
    MessagePack,
    Request,
    Sensor\CanListen,
    Signal,
    Signal\Standart
};

final class FakeConnector implements Connector
{
    use CanListen;

    /** @var Connection */
    private $connection;

    /** @var MessagePack */
    private $packer;

    public function __construct(
        Connection $connection = null,
        MessagePack $packer = null,
        Signal $signal = null
    ) {
        $this->connection = $connection ?? new FakeConnection();
        $this->packer = $packer ?? new FakeMessagePack();
        $this->signal = $signal ?? new Standart();
    }

    public function disconnect(): void
    {
        return;
    }

    public function sendRequest(Request $request): array
    {
        return [];
    }
}
