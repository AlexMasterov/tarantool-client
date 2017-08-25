<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Insert;
use const Tarantool\Protocol\{
    CODE,
    INSERT,
    SPACE_ID,
    TUPLE
};

final class InsertTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => INSERT,
        ];
        $body = [
            SPACE_ID => 'int',
            TUPLE    => 'array',
        ];

        // Execute
        $request = new Insert(
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
