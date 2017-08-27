<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Select
};

final class SelectTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::SELECT,
        ];
        $body = [
           Request::SPACE_ID => 'int',
           Request::INDEX_ID => 'int',
           Request::LIMIT    => 'int',
           Request::OFFSET   => 'int',
           Request::ITERATOR => 'int',
           Request::KEY      => 'array',
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
