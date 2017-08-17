<?php
declare(strict_types=1);

namespace Tarantool\TestSuite\Computation;

use Tarantool\Computation;

final class MonadLaws
{
    public static function leftIdentity(
        Computation $leftOf,
        Computation $rightOf,
        callable $map
    ): bool {
        return $leftOf == $rightOf->map($map);
    }

    public static function rightIdentity(
        Computation $leftOf,
        Computation $rightOf,
        callable $bind
    ): bool {
        return $leftOf == $rightOf->bind($bind);
    }

    public static function associativity(
        Computation $of,
        callable $bind,
        callable $bind2
    ): bool {
        $rightBind = function ($value) use ($bind, $bind2) {
            return $bind($value)
                ->bind(function ($value) use ($bind2) {
                    return $bind2($value);
                });
        };

        return $of->bind($bind)->bind($bind2) == $of->bind($rightBind);
    }
}
