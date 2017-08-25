<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CALL,
    CODE,
    FUNCTION_NAME,
    TUPLE
};

final class Call implements Request
{
    /** @var string */
    private $functionName;

    /** @var array */
    private $arguments;

    public function __construct(
        string $functionName,
        array $arguments = []
    ) {
        $this->functionName = $functionName;
        $this->arguments = $arguments;
    }

    public function header(): array
    {
        return [
            CODE => CALL,
        ];
    }

    public function body(): array
    {
        return [
            FUNCTION_NAME => $this->functionName,
            TUPLE => $this->arguments,
        ];
    }
}
