<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Tarantool\Client;

interface Negotiation
{
    public function negotiate(Client $client): void;
}
