<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Client\Command\{
    Authenticate,
    Call,
    Delete,
    Evaluate,
    Insert,
    Join,
    Ping,
    Replace,
    Select,
    Subscribe,
    Update,
    Upsert
};
use Tarantool\Connector\Request;
use Tarantool\Connector\Tests\Stub\Protocol;

final class CommandTest extends TestCase
{
    /**
     * @test
     * @dataProvider commands
     */
    public function it_is_valid_protocol_command(
        string $commandClass,
        ...$arguments
    ) {
        // Execute
        $command = new $commandClass(...$arguments);

        // Verify
        self::assertProtocolCommand($command);
    }

    public function commands()
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

    public static function assertProtocolCommand(Request $command): void
    {
        $header = $command->header();

        self::assertArrayHasKey(Request::CODE, $header);

        $type = $header[Request::CODE];

        self::assertArrayHasKey($type, Protocol::REQUESTS);

        $body = $command->body();

        $bodyValidator = static function ($type, $code) use ($body) {
            return false === isset($body[$code])
                && $type === gettype($body[$code]);
        };

        $invalidCodes = \array_filter(
            Protocol::REQUESTS[$type],
            $bodyValidator,
            \ARRAY_FILTER_USE_BOTH
        );

        self::assertEmpty($invalidCodes);
    }
}
