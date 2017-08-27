<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Authenticate
};

final class AuthenticateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::AUTHENTICATE,
        ];
        $body = [
            Request::TUPLE     => 'array',
            Request::USER_NAME => 'string',
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
