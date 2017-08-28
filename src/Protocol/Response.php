<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Response
{
    public const OK = 0x00;
    public const ERROR = 0x8000;

    public function get();
}
