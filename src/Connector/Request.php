<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector\Protocol\Constants;

interface Request extends Constants
{
    public function header(): array;

    public function body(): array;
}
