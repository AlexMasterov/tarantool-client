<?php
declare(strict_types=1);

namespace Tarantool\Computation\Result;

use Throwable;
use Tarantool\{
    Computation,
    Computation\Result
};

final class Failure extends Result
{
    /** @var Throwable */
    protected $throwable;

    public function bind(callable $fn): Computation
    {
        return $this;
    }

    public function map(callable $fn): Computation
    {
        return $this;
    }

    public function get()
    {
        return $this->throwable;
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function isFailure(): bool
    {
        return true;
    }

    protected function __construct(Throwable $throwable)
    {
        $this->throwable = $throwable;
    }
}
