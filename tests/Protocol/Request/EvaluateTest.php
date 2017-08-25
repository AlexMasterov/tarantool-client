<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Request;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\Request\Evaluate;
use const Tarantool\Protocol\{
    CODE,
    EVALUATE,
    EXPRESSION,
    TUPLE
};

final class EvaluateTest extends TestCase
{
    /** @test */
    public function it_is_valid_request()
    {
        // Stub
        $header = [
            CODE => EVALUATE,
        ];
        $body = [
            EXPRESSION => 'string',
            TUPLE      => 'array',
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
