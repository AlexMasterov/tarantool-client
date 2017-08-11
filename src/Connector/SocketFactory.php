<?php
declare(strict_types=1);

namespace Tarantool\Connector;

interface SocketFactory
{
    public function create(string $url) /** : resource */;
}
