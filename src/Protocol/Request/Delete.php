<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    DELETE,
    INDEX_ID,
    KEY,
    SPACE_ID
};

final class Delete implements Request
{
    /** @var int */
    private $spaceId;

    /** @var int */
    private $indexId;

    /** @var array */
    private $key;

    public function __construct(
        int $spaceId,
        int $indexId,
        array $key
    ) {
        $this->spaceId = $spaceId;
        $this->indexId = $indexId;
        $this->key = $key;
    }

    public function header(): array
    {
        return [
            CODE => DELETE,
        ];
    }

    public function body(): array
    {
        return [
            SPACE_ID => $this->spaceId,
            INDEX_ID => $this->indexId,
            KEY => $this->key,
        ];
    }
}
