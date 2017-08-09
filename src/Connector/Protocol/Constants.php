<?php
declare(strict_types=1);

namespace Tarantool\Connector\Protocol;

interface Constants
{
    const GREETING_SIZE = 128;
    const PACKET_LENGTH_BYTES = 5;
    const ERROR_CODE = 0x8000;

    const SELECT = 1;
    const INSERT = 2;
    const REPLACE = 3;
    const UPDATE = 4;
    const DELETE = 5;
    const AUTHENTICATE = 7;
    const EVALUATE = 8;
    const UPSERT = 9;
    const CALL = 10;

    const PING = 64;
    const JOIN = 65;
    const SUBSCRIBE = 66;

    const CODE = 0x00;
    const SYNC = 0x01;
    const REPLICA_ID = 0x02;
    const LSN = 0x03;
    const TIMESTAMP = 0x04;
    const SCHEMA_VERSION = 0x05;

    const SPACE_ID = 0x10;
    const INDEX_ID = 0x11;
    const LIMIT = 0x12;
    const OFFSET = 0x13;
    const ITERATOR = 0x14;

    const KEY = 0x20;
    const TUPLE = 0x21;
    const FUNCTION_NAME = 0x22;
    const USER_NAME = 0x23;
    const SERVER_UUID = 0x24;
    const CLUSTER_UUID = 0x25;
    const VCLOCK = 0x26;
    const EXPRESSION = 0x27;
    const OPERATIONS = 0x28;

    const DATA = 0x30;
    const ERROR = 0x31;
}
