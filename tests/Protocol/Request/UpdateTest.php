<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Update
};

final class UpdateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::UPDATE,
        ];
        $body = [
           Request::SPACE_ID => 'int',
           Request::INDEX_ID => 'int',
           Request::KEY      => 'array',
           Request::TUPLE    => 'array',
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
