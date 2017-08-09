<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Inserts tuple into the space, if no tuple with same unique keys exists.
 * Otherwise throw duplicate key error.
 */
final class Insert implements Command
{
    /** @var int */
    private $spaceId;

    /** @var array */
    private $values;

    public function __construct(
        int $spaceId,
        array $values
    ) {
        $this->spaceId = $spaceId;
        $this->values = $values;
    }

    public function header(): array
    {
        return [
            self::CODE => self::INSERT,
        ];
    }

    public function body(): array
    {
        return [
            self::SPACE_ID => $this->spaceId,
            self::TUPLE => $this->values,
        ];
    }
}
