<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Signal;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Unit\Signal\CanNewCounter;
use Tarantool\Connector\{
    Signal,
    Signal\Smart,
    Signal\StandartFactory
};

final class SmartTest extends TestCase
{
    use CanNewCounter;

    /** @test */
    public function it_is_working_signal()
    {
        // Stub
        $counter = $this->newCounter(0);
        $signal = $this->newSignal(
            new StandartFactory()
        );

        // Execute
        $signal->addlistener('increment', function () use ($counter) {
            $counter->increment();
        });

        $signal->beep('increment');

        // Verify
        self::assertInstanceOf(Smart::class, $signal);
        self::assertSame(1, $counter->count());
    }

    private function newSignal(...$arguments): Signal
    {
        return new Smart(...$arguments);
    }
}
