<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

final class Upsert implements Request
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
