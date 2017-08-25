<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    EVALUATE,
    EXPRESSION,
    TUPLE
};

final class Evaluate implements Request
{
    /** @var string */
    private $expression;

    /** @var array */
    private $arguments;

    public function __construct(
        string $expression,
        array $arguments = []
    ) {
        $this->expression = $expression;
        $this->arguments = $arguments;
    }

    public function header(): array
    {
        return [
            CODE => EVALUATE,
        ];
    }

    public function body(): array
    {
        return [
            EXPRESSION => $this->expression,
            TUPLE => $this->arguments,
        ];
    }
}
