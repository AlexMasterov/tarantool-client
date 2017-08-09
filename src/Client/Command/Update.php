<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Update a tuple
 */
final class Update implements Command
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
            self::CODE => self::UPDATE,
        ];
    }

    public function body(): array
    {
        return [
            self::SPACE_ID => $this->spaceId,
            self::INDEX_ID => $this->indexId,
            self::KEY => $this->key,
            self::TUPLE => $this->operations,
        ];
    }
}
