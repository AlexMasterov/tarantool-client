<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

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
            self::CODE => self::AUTHENTICATE,
        ];
    }

    public function body(): array
    {
        return [
            self::TUPLE => $this->tuple,
            self::USER_NAME => $this->username,
        ];
    }
}
