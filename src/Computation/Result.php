<?php
declare(strict_types=1);

namespace Tarantool\Computation;

use Tarantool\Computation\Result\{
    Failure,
    Success
};
use Tarantool\{
    Client\Response,
    Computation
};

abstract class Result implements Computation, Response
{
    /** @var mixed */
    protected $content = null;

    final public static function of($x): Computation
    {
        return new Success($x);
    }

    final public static function success($x): Computation
    {
        return new Success($x);
    }

    final public static function failure($x): Computation
    {
        return new Failure($x);
    }

    abstract public function bind(callable $fn): Computation;

    abstract public function map(callable $fn): Computation;

    abstract public function get();

    abstract public function isSuccess(): bool;

    abstract public function isFailure(): bool;

    private function __construct($content)
    {
        $this->content = $content;
    }
}
