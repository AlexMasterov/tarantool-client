<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use DateInterval;
use Tarantool\Connector;
use Tarantool\Connector\Tests\Stub\{
    CanGenerateGreeting,
    FakeMessagePack
};
use Tarantool\Connector\{
    Connection,
    Connection\AutomaticConnection,
    MessagePack,
    Request,
    Sensor\CanListen,
    Signal,
    Signal\Standart
};
use Closure;

final class FakeConnector implements Connector
{
    use CanListen;
    use CanGenerateGreeting;

    /** @var Connection */
    private $connection;

    /** @var MessagePack */
    private $packer;

    /** @var array */
    private $listeners = [];

    public function __construct(
        Connection $connection = null,
        MessagePack $packer = null,
        Signal $signal = null
    ) {
        $this->connection = $connection ?? new AutomaticConnection(
            new FakeConnection(),
            new DateInterval('PT1S')
        );
        $this->packer = $packer ?? new FakeMessagePack();
        $this->signal = $signal ?? new Standart();

        $this->connection->listen('open', function () {
            $this->listen('connect', function () {
                $greeting = $this->generateGreeting('12345678901234567890');
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
        $this->connection->send('data');

        return [];
    }
}
