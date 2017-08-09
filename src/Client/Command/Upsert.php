<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Update tuple if it would be found elsewhere try to insert tuple.
 * Always use primary index for key.
 */
final class Upsert implements Command
{
    /** @var int */
    private $spaceId;

    /** @var array */
    private $values;

    /** @var array */
    private $operations;

    public function __construct(
        int $spaceId,
        array $values,
        array $operations
    ) {
        $this->spaceId = $spaceId;
        $this->values = $values;
        $this->operations = $operations;
    }

    public function header(): array
    {
        return [
            self::CODE => self::UPSERT,
        ];
    }

    public function body(): array
    {
        return [
            self::SPACE_ID => $this->spaceId,
            self::TUPLE => $this->values,
            self::OPERATIONS => $this->operations,
        ];
    }
}
