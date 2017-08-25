<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Delete;
use const Tarantool\Protocol\{
    CODE,
    DELETE,
    INDEX_ID,
    KEY,
    SPACE_ID
};

final class DeleteTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => DELETE,
        ];
        $body = [
            SPACE_ID => 'int',
            INDEX_ID => 'int',
            KEY      => 'array',
        ];

        // Execute
        $request = new Delete(
            1,
            1,
            ['key' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
