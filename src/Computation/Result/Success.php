<?php
declare(strict_types=1);

namespace Tarantool\Computation\Result;

use Tarantool\{
    Computation,
    Computation\ComputationException,
    Computation\Result
};

final class Success extends Result
{
    public function bind(callable $fn): Computation
    {
        try {
            return $fn($this->content);
        } catch (ComputationException $exception) {
            return Result::failure($exception);
        }
    }

    public function map(callable $fn): Computation
    {
        try {
            return Result::success($fn($this->content));
        } catch (ComputationException $exception) {
            return Result::failure($exception);
        }
    }

    public function get()
    {
        return $this->content;
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
