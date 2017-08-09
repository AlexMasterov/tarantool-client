<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\Client\{
    Command,
    Response,
    Session
};

interface Client
{
    public function createSession(Session $session): void;

    public function destroySession(): void;

    public function hasSession(): bool;

    public function getSession(): Session;

    public function request(Command $command): Response;
}
