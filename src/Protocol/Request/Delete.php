<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

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
