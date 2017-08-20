<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Request,
    Request\Authenticate,
    Request\Call,
    Request\Delete,
    Request\Evaluate,
    Request\Insert,
    Request\Join,
    Request\Ping,
    Request\Replace,
    Request\Select,
    Request\Subscribe,
    Request\Update,
    Request\Upsert
};
use Tarantool\TestSuite\Protocol;

final class RequestTest extends TestCase
{
    /**
     * @test
     * @dataProvider requestsData
     */
    public function it_is_valid_protocol_request(
        string $requestClass,
        ...$arguments
    ) {
        // Execute
        $request = new $requestClass(...$arguments);

        // Verify
        self::assertTrue(Protocol::validate($request));
    }

    public function requestsData()
    {
        return [
            [Authenticate::class, ['chap-sha1'], 'username'],
            [Call::class, 'functionName', ['argument' => 'xyz']],
            [Delete::class, 1, 1, ['key' => 'xyz']],
            [Evaluate::class, 'expression', ['argument' => 'xyz']],
            [Insert::class, 1, ['values' => 'xyz']],
            [Join::class, 'uuid'],
            [Ping::class],
            [Replace::class, 1, ['values' => 'xyz']],
            [Select::class, 1, 1, ['key' => 'xyz'], 1, 1, 1],
            [Subscribe::class, 'uuid', 'uuid', ['vclock' => 'xyz']],
            [Update::class, 1, 1, ['key' => 'xyz'], ['operations' => 'xyz']],
            [Upsert::class, 1, ['values' => 'xyz'], ['operations' => 'xyz']],
        ];
    }
}
