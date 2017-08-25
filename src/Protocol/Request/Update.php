<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    INDEX_ID,
    KEY,
    SPACE_ID,
    TUPLE,
    UPDATE
};

final class Update implements Request
{
    /** @var int */
    private $spaceId;

    /** @var int */
    private $indexId;

    /** @var array */
    private $key;

    /** @var array */
    private $operations;

    public function __construct(
        int $spaceId,
        int $indexId,
        array $key,
        array $operations
    ) {
        $this->spaceId = $spaceId;
        $this->indexId = $indexId;
        $this->key = $key;
        $this->operations = $operations;
    }

    public function header(): array
    {
        return [
            CODE => UPDATE,
        ];
    }

    public function body(): array
    {
        return [
            SPACE_ID => $this->spaceId,
            INDEX_ID => $this->indexId,
            KEY => $this->key,
            TUPLE => $this->operations,
        ];
    }
}
