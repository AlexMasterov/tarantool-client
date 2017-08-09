<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Evaulate Lua expression
 */
final class Evaluate implements Command
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
            self::CODE => self::EVALUATE,
        ];
    }

    public function body(): array
    {
        return [
            self::EXPRESSION => $this->expression,
            self::TUPLE => $this->arguments,
        ];
    }
}
