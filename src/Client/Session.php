<?php
declare(strict_types=1);

namespace Tarantool\Client;

use DateTimeImmutable;

interface Session
{
    public function createdAt(): DateTimeImmutable;

    public function server(): string;

    public function salt(): string;
}
