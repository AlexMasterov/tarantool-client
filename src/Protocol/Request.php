<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Request
{
    public function header(): array;

    public function body(): array;
}
