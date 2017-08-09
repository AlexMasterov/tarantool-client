<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Closure;
use RuntimeException;
use Tarantool\Connector\Tests\Stub\State;
use Tarantool\Connector\{
    Connection,
    Sensor\CanListen,
    Signal\Standart
};

final class FakeConnection implements Connection
{
    use CanListen;

    /** @var int */
    private $state = State::NONE;

    /** @var array */
    private $buffer = [];

    public function __construct()
    {
        $this->signal = new Standart();
        $this->reset();
    }

    public function open(): void
    {
        if ($this->state >= State::CONNECTED) {
            throw new RuntimeException('Cannot connect while already connected');
        }

        $this->setState(State::CONNECTED);
        $this->signal->beep('open');
    }

    public function close(): void
    {
        if ($this->state === State::NONE) {
            throw new RuntimeException('Cannot disconnect while not connected');
        }

        $this->reset();
        $this->signal->beep('close');
    }

    public function send(string $data): int
    {
        if ($this->state === State::NONE) {
            throw new RuntimeException('Cannot communicate while not connected');
        }

        $this->signal->beep('send', $data);

        return 1;
    }

    public function receive(int $bytes): string
    {
        $this->setState(State::DATA_RECEIVED);
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

    private function setState(int $state): void
    {
        $this->state = $state;
    }

    private function reset(): void
    {
        $this->buffer = [];
        $this->setState(State::NONE);
    }
}
