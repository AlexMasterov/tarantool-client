<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Ping,
    Request\SyncRequest
};

final class SyncRequestTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $synchronizedRequest = new Ping();
        $value = 1;

        $header = [
            Request::SYNC => $value,
        ] + $synchronizedRequest->header();
        $body = $synchronizedRequest->body();

        // Execute
        $request = new SyncRequest(
            $synchronizedRequest,
            $value
        );

        // Verify
        self::assertSame($header, $request->header());
        self::assertSame($body, $request->body());
    }
}
