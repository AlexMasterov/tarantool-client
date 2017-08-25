<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    OPERATIONS,
    SPACE_ID,
    TUPLE,
    UPSERT
};

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
            CODE => UPSERT,
        ];
    }

    public function body(): array
    {
        return [
            SPACE_ID => $this->spaceId,
            TUPLE => $this->values,
            OPERATIONS => $this->operations,
        ];
    }
}
