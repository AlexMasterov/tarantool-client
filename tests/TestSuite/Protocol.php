<?php
declare(strict_types=1);

namespace Tarantool\TestSuite;

use Tarantool\Protocol\{
    Constants,
    Request
};

final class Protocol implements Constants
{
    private const REQUESTS = [
        self::PING => [],
        self::AUTHENTICATE => [
            self::TUPLE     => 'array',
            self::USER_NAME => 'string',
        ],
        self::SELECT => [
            self::KEY      => 'int',
            self::SPACE_ID => 'int',
            self::INDEX_ID => 'array',
            self::LIMIT    => 'int',
            self::OFFSET   => 'int',
            self::ITERATOR => 'int',
        ],
        self::INSERT => [
            self::SPACE_ID => 'int',
            self::TUPLE    => 'array',
        ],
        self::REPLACE => [
            self::SPACE_ID => 'int',
            self::TUPLE    => 'array',
        ],
        self::UPDATE => [
            self::SPACE_ID => 'int',
            self::INDEX_ID => 'int',
            self::KEY      => 'array',
            self::TUPLE    => 'array',
        ],
        self::DELETE => [
            self::SPACE_ID => 'int',
            self::INDEX_ID => 'int',
            self::KEY      => 'array',
        ],
        self::EVALUATE => [
            self::EXPRESSION => 'string',
            self::TUPLE      => 'array',
        ],
        self::UPSERT => [
            self::SPACE_ID   => 'int',
            self::TUPLE      => 'array',
            self::OPERATIONS => 'array',
        ],
        self::CALL => [
            self::FUNCTION_NAME => 'string',
            self::TUPLE         => 'array',
        ],
        self::JOIN => [
            self::SERVER_UUID => 'string',
        ],
        self::SUBSCRIBE => [
            self::SERVER_UUID  => 'string',
            self::CLUSTER_UUID => 'string',
            self::VCLOCK       => 'array',
        ],
    ];

    public static function validate(Request $request)
    {
        $header = $request->header();

        if (!isset($header[Request::CODE])) {
            return false;
        }

        $type = $header[Request::CODE];

        if (!isset(self::REQUESTS[$type])) {
            return false;
        }

        $body = $request->body();

        $bodyValidator = static function ($type, $code) use ($body) {
            return false === isset($body[$code])
                && $type === gettype($body[$code]);
        };

        $invalidCodes = \array_filter(
            self::REQUESTS[$type],
            $bodyValidator,
            \ARRAY_FILTER_USE_BOTH
        );

        if (!empty($invalidCodes)) {
            return false;
        }

        return true;
    }
}
