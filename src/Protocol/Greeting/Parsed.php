<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Greeting;

use Tarantool\Protocol\{
    Greeting,
    Greeting\GreetingException
};

final class Parsed implements Greeting
{
    /** @const int */
    private const MIN_LENGTH = self::LENGTH - 1;

    /** @var string */
    private $server;

    /** @var string */
    private $salt;

    public function __construct(string $greeting)
    {
        if (!isset($greeting[self::MIN_LENGTH])) {
            throw GreetingException::invalidLength();
        }

        $this->server = $this->parseServer($greeting);
        $this->salt = $this->parseSalt($greeting);
    }

    public function server(): string
    {
        return $this->server;
    }

    public function salt(): string
    {
        return $this->salt;
    }

    private function parseServer(string $greeting)
    {
        $server = \substr($greeting, 0, self::SERVER_LENGTH);

        if (0 === \strpos($server, 'Tarantool')) {
            return \rtrim($server);
        }

        throw GreetingException::unableRecognizeServer($server);
    }

    private function parseSalt(string $greeting): string
    {
        $encodedSalt = \substr($greeting, self::SERVER_LENGTH, self::SALT_LENGTH);
        $decodedSalt = \base64_decode($encodedSalt, true);

        if (false !== $decodedSalt) {
            return $decodedSalt;
        }

        throw GreetingException::unableDecodeSalt($encodedSalt);
    }
}
