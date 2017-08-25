<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Call;
use const Tarantool\Protocol\{
    CALL,
    CODE,
    FUNCTION_NAME,
    TUPLE
};

final class CallTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => CALL,
        ];
        $body = [
            FUNCTION_NAME => 'string',
            TUPLE         => 'array',
        ];

        // Execute
        $request = new Call(
            'functionName',
            ['argument' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
