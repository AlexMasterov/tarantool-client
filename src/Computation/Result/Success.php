<?php
declare(strict_types=1);

namespace Tarantool\Computation\Result;

use Tarantool\{
    Computation,
    Computation\Result
};
use Throwable;

final class Success extends Result
{
    public function bind(callable $fn): Computation
    {
        try {
            return $fn($this->value);
        } catch (Throwable $throwable) {
            return Result::failure($throwable);
        }
    }

    public function map(callable $fn): Computation
    {
        try {
            return Result::success($fn($this->value));
        } catch (Throwable $throwable) {
            return Result::failure($throwable);
        }
    }

    public function get()
    {
        return $this->value;
    }

    public function isSuccess(): bool
    {
        return true;
    }

    public function isFailure(): bool
    {
        return false;
    }
}
