<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Ping
};

final class PingTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::PING,
        ];
        $body = [];

        // Execute
        $request = new Ping();

        // Verify
        self::assertSame($header, $request->header());
        self::assertSame($body, $request->body());
    }
}
