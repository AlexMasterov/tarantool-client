<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Tarantool\Connector\Protocol\Constants;

interface Protocol
{
    public const REQUESTS = [
        Constants::PING => [],
        Constants::AUTHENTICATE => [
            Constants::TUPLE     => 'array',
            Constants::USER_NAME => 'string',
        ],
        Constants::SELECT => [
            Constants::KEY      => 'int',
            Constants::SPACE_ID => 'int',
            Constants::INDEX_ID => 'array',
            Constants::LIMIT    => 'int',
            Constants::OFFSET   => 'int',
            Constants::ITERATOR => 'int',
        ],
        Constants::INSERT => [
            Constants::SPACE_ID => 'int',
            Constants::TUPLE    => 'array',
        ],
        Constants::REPLACE => [
            Constants::SPACE_ID => 'int',
            Constants::TUPLE    => 'array',
        ],
        Constants::UPDATE => [
            Constants::SPACE_ID => 'int',
            Constants::INDEX_ID => 'int',
            Constants::KEY      => 'array',
            Constants::TUPLE    => 'array',
        ],
        Constants::DELETE => [
            Constants::SPACE_ID => 'int',
            Constants::INDEX_ID => 'int',
            Constants::KEY      => 'array',
        ],
        Constants::EVALUATE => [
            Constants::EXPRESSION => 'string',
            Constants::TUPLE      => 'array',
        ],
        Constants::UPSERT => [
            Constants::SPACE_ID   => 'int',
            Constants::TUPLE      => 'array',
            Constants::OPERATIONS => 'array',
        ],
        Constants::CALL => [
            Constants::FUNCTION_NAME => 'string',
            Constants::TUPLE         => 'array',
        ],
        Constants::JOIN => [
            Constants::SERVER_UUID => 'string',
        ],
        Constants::SUBSCRIBE => [
            Constants::SERVER_UUID  => 'string',
            Constants::CLUSTER_UUID => 'string',
            Constants::VCLOCK       => 'array',
        ],
    ];
}
