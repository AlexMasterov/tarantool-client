<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Subscribe;
use const Tarantool\Protocol\{
    CLUSTER_UUID,
    CODE,
    SERVER_UUID,
    SUBSCRIBE,
    VCLOCK
};

final class SubscribeTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => SUBSCRIBE,
        ];
        $body = [
            SERVER_UUID  => 'string',
            CLUSTER_UUID => 'string',
            VCLOCK       => 'array',
        ];

        // Execute
        $request = new Subscribe(
            'uuid',
            'uuid',
            ['vclock' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
