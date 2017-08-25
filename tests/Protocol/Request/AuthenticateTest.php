<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Authenticate;
use const Tarantool\Protocol\{
    AUTHENTICATE,
    CODE,
    TUPLE,
    USER_NAME
};

final class AuthenticateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => AUTHENTICATE,
        ];
        $body = [
            TUPLE     => 'array',
            USER_NAME => 'string',
        ];

        // Execute
        $request = new Authenticate(
            ['chap-sha1'],
            'username'
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
