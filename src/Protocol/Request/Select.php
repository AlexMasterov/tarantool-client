<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    INDEX_ID,
    ITERATOR,
    KEY,
    LIMIT,
    OFFSET,
    SELECT,
    SPACE_ID
};

final class Select implements Request
{
    /** @var int */
    private $spaceId;

    /** @var int */
    private $indexId;

    /** @var array */
    private $key;

    /** @var int */
    private $offset;

    /** @var int */
    private $limit;

    /** @var int */
    private $iterator;

    public function __construct(
        int $spaceId,
        int $indexId,
        array $key,
        int $offset,
        int $limit,
        int $iterator
    ) {
        $this->spaceId = $spaceId;
        $this->indexId = $indexId;
        $this->key = $key;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->iterator = $iterator;
    }

    public function header(): array
    {
        return [
            CODE => SELECT,
        ];
    }

    public function body(): array
    {
        return [
            SPACE_ID => $this->spaceId,
            INDEX_ID => $this->indexId,
            LIMIT => $this->limit,
            OFFSET => $this->offset,
            ITERATOR => $this->iterator,
            KEY => $this->key,
        ];
    }
}
