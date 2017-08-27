<?php
declare(strict_types=1);

namespace Tarantool\Client\Session;

use DateTimeImmutable;
use Tarantool\{
    Session,
    Protocol\Greeting
};

final class Single implements Session
{
    /** @var DateTimeImmutable */
    private $createdAt;

    /** @var string */
    private $server;

    /** @var string */
    private $salt;

    public function __construct(Greeting $greeting)
    {
        $this->createdAt = new DateTimeImmutable('now');
        $this->server = $greeting->server();
        $this->salt = $greeting->salt();
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function server(): string
    {
        return $this->server;
    }

    public function salt(): string
    {
        return $this->salt;
    }
}
