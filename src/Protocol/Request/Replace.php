<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

final class Replace implements Request
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
