<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

interface Request
{
    public const PACKET_LENGTH_BYTES = 5;

    public const SELECT = 1;
    public const INSERT = 2;
    public const REPLACE = 3;
    public const UPDATE = 4;
    public const DELETE = 5;
    public const AUTHENTICATE = 7;
    public const EVALUATE = 8;
    public const UPSERT = 9;
    public const CALL = 10;
    public const EXECUTE = 11;

    public const PING = 64;
    public const JOIN = 65;
    public const SUBSCRIBE = 66;

    public const CODE = 0x00;
    public const SYNC = 0x01;

    public const REPLICA_ID = 0x02;
    public const LSN = 0x03;
    public const TIMESTAMP = 0x04;
    public const SCHEMA_VERSION = 0x05;

    public const SPACE_ID = 0x10;
    public const INDEX_ID = 0x11;
    public const LIMIT = 0x12;
    public const OFFSET = 0x13;
    public const ITERATOR = 0x14;

    public const KEY = 0x20;
    public const TUPLE = 0x21;
    public const FUNCTION_NAME = 0x22;
    public const USER_NAME = 0x23;
    public const SERVER_UUID = 0x24;
    public const CLUSTER_UUID = 0x25;
    public const VCLOCK = 0x26;
    public const EXPRESSION = 0x27;
    public const OPERATIONS = 0x28;

    public const SQL_TEXT = 0x40;
    public const SQL_BIND = 0x41;

    public function header(): array;

    public function body(): array;
}
