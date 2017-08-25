<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CLUSTER_UUID,
    CODE,
    SERVER_UUID,
    SUBSCRIBE,
    VCLOCK
};

final class Subscribe implements Request
{
    /** @var string */
    private $clusterUuid;

    /** @var string */
    private $serverUuid;

    /** @var array */
    private $vclock;

    public function __construct(
        string $clusterUuid,
        string $serverUuid,
        array $vclock
    ) {
        $this->clusterUuid = $clusterUuid;
        $this->serverUuid = $serverUuid;
        $this->vclock = $vclock;
    }

    public function header(): array
    {
        return [
            CODE => SUBSCRIBE,
        ];
    }

    public function body(): array
    {
        return [
            CLUSTER_UUID => $this->clusterUuid,
            SERVER_UUID => $this->serverUuid,
            VCLOCK => $this->vclock,
        ];
    }
}
