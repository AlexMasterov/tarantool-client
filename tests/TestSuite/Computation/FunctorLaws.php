<?php
declare(strict_types=1);

namespace Tarantool\TestSuite\Computation;

use Tarantool\Computation;

final class FunctorLaws
{
    public static function identity(
        Computation $of,
        callable $map
    ): bool {
        return $of == $of->map($map);
    }

    public static function composition(
        Computation $of,
        callable $map,
        callable $map2
    ): bool {
        $fn = function ($x) use ($map2, $map) {
            return $map2($map($x));
        };

        return $of->map($map)->map($map2) == $of->map($fn);
    }
}
