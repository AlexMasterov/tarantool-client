<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

final class Subscribe implements Command
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
            self::CODE => self::SUBSCRIBE,
        ];
    }

    public function body(): array
    {
        return [
            self::CLUSTER_UUID => $this->clusterUuid,
            self::SERVER_UUID => $this->serverUuid,
            self::VCLOCK => $this->vclock,
        ];
    }
}
