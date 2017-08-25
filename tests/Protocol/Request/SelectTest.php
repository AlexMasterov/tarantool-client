<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Select;
use const Tarantool\Protocol\{
    CODE,
    INDEX_ID,
    ITERATOR,
    KEY,
    LIMIT,
    OFFSET,
    SELECT,
    SPACE_ID
};

final class SelectTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => SELECT,
        ];
        $body = [
            SPACE_ID => 'int',
            INDEX_ID => 'int',
            LIMIT    => 'int',
            OFFSET   => 'int',
            ITERATOR => 'int',
            KEY      => 'array',
        ];

        // Execute
        $request = new Select(
            1,
            1,
            ['key' => 'xyz'],
            1,
            1,
            1
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
