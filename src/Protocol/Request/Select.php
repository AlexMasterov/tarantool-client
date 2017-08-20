<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

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
            self::CODE => self::SELECT,
        ];
    }

    public function body(): array
    {
        return [
            self::KEY => $this->key,
            self::SPACE_ID => $this->spaceId,
            self::INDEX_ID => $this->indexId,
            self::LIMIT => $this->limit,
            self::OFFSET => $this->offset,
            self::ITERATOR => $this->iterator,
        ];
    }
}
