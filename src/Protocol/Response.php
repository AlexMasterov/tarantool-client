<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Response
{
    public const OK = 0x00;
    public const ERRORS = 0x8000;

    public const FIELD_NAME = 0x29;
    public const DATA = 0x30;
    public const ERROR = 0x31;
    public const METADATA = 0x32;

    public const SQL_OPTIONS = 0x42;
    public const SQL_INFO = 0x43;
    public const SQL_ROW_COUNT = 0x44;

    public function get();
}
