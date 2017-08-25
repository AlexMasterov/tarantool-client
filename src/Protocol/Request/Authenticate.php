<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    AUTHENTICATE,
    CODE,
    TUPLE,
    USER_NAME
};

final class Authenticate implements Request
{
    /** @var array */
    private $tuple;

    /** @var string */
    private $username;

    public function __construct(
        array $tuple,
        string $username
    ) {
        $this->tuple = $tuple;
        $this->username = $username;
    }

    public function header(): array
    {
        return [
            CODE => AUTHENTICATE,
        ];
    }

    public function body(): array
    {
        return [
            TUPLE => $this->tuple,
            USER_NAME => $this->username,
        ];
    }
}
