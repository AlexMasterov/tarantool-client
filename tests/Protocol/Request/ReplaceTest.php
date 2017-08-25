<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Replace;
use const Tarantool\Protocol\{
    CODE,
    REPLACE,
    SPACE_ID,
    TUPLE
};

final class ReplaceTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => REPLACE,
        ];
        $body = [
            SPACE_ID => 'int',
            TUPLE    => 'array',
        ];

        // Execute
        $request = new Replace(
            1,
            ['values' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
