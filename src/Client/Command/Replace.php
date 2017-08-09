<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

/**
 * Insert a tuple into the space or replace an existing one.
 */
final class Replace implements Command
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
            self::CODE => self::REPLACE,
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
