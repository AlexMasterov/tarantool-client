<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Subscribe
};

final class SubscribeTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::SUBSCRIBE,
        ];
        $body = [
            Request::SERVER_UUID  => 'string',
            Request::CLUSTER_UUID => 'string',
            Request::VCLOCK       => 'array',
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
