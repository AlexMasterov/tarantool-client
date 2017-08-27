<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Evaluate
};

final class EvaluateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            Request::CODE => Request::EVALUATE,
        ];
        $body = [
           Request::EXPRESSION => 'string',
           Request::TUPLE      => 'array',
        ];

        // Execute
        $request = new Evaluate(
            'expression',
            ['argument' => 'xyz']
        );

        // Verify
        self::assertSame($header, $request->header());

        foreach ($request->body() as $key => $value) {
            self::assertArrayHasKey($key, $body);
            self::assertInternalType($body[$key], $value);
        }
    }
}
