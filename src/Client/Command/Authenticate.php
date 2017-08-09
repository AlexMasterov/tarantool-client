<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

final class Authenticate implements Command
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
