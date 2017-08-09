<?php
declare(strict_types=1);

namespace Tarantool\Computation\Result;

use Tarantool\{
    Computation,
    Computation\ComputationException,
    Computation\Result
};

final class Failure extends Result
{
    /** @var ComputationException */
    protected $exception = null;

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
        return $this->exception;
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function isFailure(): bool
    {
        return true;
    }

    protected function __construct(ComputationException $exception)
    {
        $this->exception = $exception;
    }
}
