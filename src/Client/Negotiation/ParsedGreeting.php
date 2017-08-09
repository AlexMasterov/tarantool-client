<?php
declare(strict_types=1);

namespace Tarantool\Client\Negotiation;

use Tarantool\Client\ClientException;
use function Tarantool\Client\parse_greeting;

final class ParsedGreeting
{
    /** @var array */
    private $message;

    public function __construct(string $greeting)
    {
        if (0 !== \strpos($greeting, 'Tarantool')) {
            throw ClientException::invalidGreeting();
        }

        if (null === $message = parse_greeting($greeting)) {
            throw ClientException::unableParseGreeting();
        }

        $this->message = $message;
    }

    public function message(): array
    {
        return $this->message;
    }
}
