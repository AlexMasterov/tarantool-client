<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Closure;
use RuntimeException;
use Tarantool\Connector\{
    Connection,
    Sensor\CanListen,
    Signal\Standart
};

final class FakeConnection implements Connection
{
    use CanListen;

    public const CLOSED = 0;
    public const CONNECTED = 1;
    public const DATA_SENT = 2;
    public const DATA_RECEIVED = 3;

    /** @var int */
    private $state = self::CLOSED;

    /** @var array */
    private $buffer = [];

    public function __construct()
    {
        $this->signal = new Standart();
        $this->reset();
    }

    public function open(): void
    {
        if ($this->state >= self::CONNECTED) {
            throw new RuntimeException('Cannot connect while already connected');
        }

        $this->state = self::CONNECTED;
        $this->signal->beep('open');
    }

    public function close(): void
    {
        if ($this->state === self::CLOSED) {
            throw new RuntimeException('Cannot disconnect while not connected');
        }

        $this->reset();
        $this->signal->beep('close');
    }

    public function send(string $data): int
    {
        if ($this->state === self::CLOSED) {
            throw new RuntimeException('Cannot communicate while not connected');
        }

        $this->state = self::DATA_SENT;
        $this->signal->beep('send', $data);

        return \strlen($data);
    }

    public function receive(int $bytes): string
    {
        $this->state = self::DATA_RECEIVED;
        $this->signal->beep('receive', $bytes);

        return 'ce000000088200000100810102';
    }

    public function buffer(): array
    {
        return $this->buffer;
    }

    public function state(): int
    {
        return $this->state;
    }

    private function reset(): void
    {
        $this->buffer = [];
        $this->state = self::CLOSED;
    }
}
