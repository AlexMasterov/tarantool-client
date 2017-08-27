<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\{
    Protocol\Greeting,
    Protocol\Request,
    Protocol\Response,
    Session
};

interface Client
{
    public function createSession(Greeting $greeting): void;

    public function destroySession(): void;

    public function hasSession(): bool;

    public function getSession(): Session;

    public function request(Request $request): Response;
}
