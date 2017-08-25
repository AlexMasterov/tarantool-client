<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    INSERT,
    SPACE_ID,
    TUPLE
};

final class Insert implements Request
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
            CODE => INSERT,
        ];
    }

    public function body(): array
    {
        return [
            SPACE_ID => $this->spaceId,
            TUPLE => $this->values,
        ];
    }
}
