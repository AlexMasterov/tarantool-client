<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Upsert;
use const Tarantool\Protocol\{
    CODE,
    OPERATIONS,
    SPACE_ID,
    TUPLE,
    UPSERT
};

final class UpsertTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => UPSERT,
        ];
        $body = [
            SPACE_ID   => 'int',
            TUPLE      => 'array',
            OPERATIONS => 'array',
        ];

        // Execute
        $request = new Upsert(
            1,
            ['values' => 'xyz'],
            ['operations' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
