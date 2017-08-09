<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\Signal;

trait CanNewCounter
{
    private function newCounter(int $initialCount = 0)
    {
        return new class($initialCount) {
            private $count;

            public function __construct(int $initialCount)
            {
                $this->count = $initialCount;
            }

            public function increment(): void
            {
                ++$this->count;
            }

            public function count(): int
            {
                return $this->count;
            }
        };
    }
}
