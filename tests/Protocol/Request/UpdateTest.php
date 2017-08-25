<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Update;
use const Tarantool\Protocol\{
    CODE,
    INDEX_ID,
    KEY,
    SPACE_ID,
    TUPLE,
    UPDATE
};

final class UpdateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => UPDATE,
        ];
        $body = [
            SPACE_ID => 'int',
            INDEX_ID => 'int',
            KEY      => 'array',
            TUPLE    => 'array',
        ];

        // Execute
        $request = new Update(
            1,
            1,
            ['key' => 'xyz'],
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
