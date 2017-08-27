<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Greeting
{
    public const LENGTH = 128;
    public const SERVER_LENGTH = 64;
    public const SALT_LENGTH = 44;

    public function server(): string;

    public function salt(): string;
}
