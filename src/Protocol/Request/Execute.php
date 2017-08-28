<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

final class Execute implements Request
{
    /** @var string */
    private $sql;

    /** @var array */
    private $parameters;

    public function __construct(
        string $sql,
        array $parameters
    ) {
        $this->sql = $sql;
        $this->parameters = $parameters;
    }

    public function header(): array
    {
        return [
            self::CODE => self::EXECUTE,
        ];
    }

    public function body(): array
    {
        return [
            self::SQL_TEXT => $this->sql,
            self::SQL_BIND => $this->parameters,
        ];
    }
}
