<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

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
            self::CODE => self::CALL,
        ];
    }

    public function body(): array
    {
        return [
            self::FUNCTION_NAME => $this->functionName,
            self::TUPLE => $this->arguments,
        ];
    }
}
