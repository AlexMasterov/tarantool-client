<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Delete a tuple
 */
final class Delete implements Command
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
            self::CODE => self::DELETE,
        ];
    }

    public function body(): array
    {
        return [
            self::SPACE_ID => $this->spaceId,
            self::INDEX_ID => $this->indexId,
            self::KEY => $this->key,
        ];
    }
}
