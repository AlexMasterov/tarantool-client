<?php
declare(strict_types=1);

namespace Tarantool;

use DateTimeImmutable;
use Tarantool\Protocol\Greeting;

interface Session extends Greeting
{
    public function createdAt(): DateTimeImmutable;
}
