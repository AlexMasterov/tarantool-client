<?php
declare(strict_types=1);

namespace Tarantool\Protocol\MessagePack;

use Closure;
use Tarantool\Protocol\Request;

trait CanMemoizePack
{
    /** @var array */
    private $memoizeCache = [];

    private function memoizePack(Closure $expression): Closure
    {
        return function (Request $request) use ($expression): string {
            $parametersHash = \md5(\serialize($request));
            return $this->memoizeCache[$parametersHash]
                ?? $this->memoizeCache[$parametersHash] = $expression($request);
        };
    }
}
