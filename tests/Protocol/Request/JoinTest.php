<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Join;
use const Tarantool\Protocol\{
    CODE,
    JOIN,
    SERVER_UUID
};

final class JoinTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => JOIN,
        ];
        $body = [
            SERVER_UUID => 'string',
        ];

        // Execute
        $request = new Join(
            'uuid'
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
