<?php
declare(strict_types=1);

namespace Tarantool;

interface Computation
{
    public static function of($x): Computation;

    public function bind(callable $fn): Computation;

    public function map(callable $fn): Computation;
}
