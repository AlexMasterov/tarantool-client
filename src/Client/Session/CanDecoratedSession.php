<?php
declare(strict_types=1);

namespace Tarantool\Client\Session;

use Tarantool\Session;

trait CanDecoratedSession
{
    /** @var Client|null */
    private $decoratedClient = null;

    public function createSession(Session $session): void
    {
        $this->getClient()->createSession($session);
    }

    final public function destroySession(): void
    {
        $this->getClient()->destroySession();
    }

    public function getSession(): Session
    {
        return $this->getClient()->getSession();
    }

    public function hasSession(): bool
    {
        return $this->getClient()->hasSession();
    }
}
