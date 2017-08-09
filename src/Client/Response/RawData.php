<?php
declare(strict_types=1);

namespace Tarantool\Client\Response;

use Tarantool\Client\Response;

final class RawData implements Response
{
    /** @var array */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get()
    {
        return $this->data;
    }
}
