<?php
declare(strict_types=1);

namespace Tarantool\Client\Session;

use Tarantool\{
    Client\ClientException,
    Protocol\Greeting,
    Session
};

trait CanSession
{
    /** @var Connector|null */
    private $connector = null;

    /** @var Session|null */
    private $session = null;

    public function createSession(Greeting $greeting): void
    {
        $this->session = new Single($greeting);
    }

    public function destroySession(): void
    {
        $this->connector->disconnect();
        $this->session = null;
    }

    public function getSession(): Session
    {
        if (isset($this->session)) {
            return $this->session;
        }

        throw ClientException::sessionNotFound();
    }

    public function hasSession(): bool
    {
        return isset($this->session);
    }
}
