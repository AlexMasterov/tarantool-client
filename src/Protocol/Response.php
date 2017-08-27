<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Response
{
    public const ERROR_CODE = 0x8000;

    public function get();
}
