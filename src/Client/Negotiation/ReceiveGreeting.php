<?php
declare(strict_types=1);

namespace Tarantool\Client\Negotiation;

use Tarantool\Client;
use Tarantool\Client\{
    Negotiation,
    Protocol\Greeting\Parsed
};

final class ReceiveGreeting implements Negotiation
{
    /** @var string */
    private $greeting;

    public function __construct(string $greeting)
    {
        $this->greeting = $greeting;
    }

    public function negotiate(Client $client): void
    {
        if ($client->hasSession()) {
            return;
        }

        $parsedGreeting = new Parsed($this->greeting);

        $client->createSession($parsedGreeting);
    }
}
