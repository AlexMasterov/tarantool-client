<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\CanGenerateGreeting;
use Tarantool\Client\{
    ClientException,
    Negotiation\ParsedGreeting
};

/** @link https://github.com/tarantool-php/client/blob/master/tests/GreetingDataProvider.php */
final class ParsedGreetingTest extends TestCase
{
    use CanGenerateGreeting;

    /**
     * @test
     * @dataProvider greetings_with_invalid_server_name
     */
    public function it_is_throw_on_greetings_with_invalid_server_name($greeting)
    {
        // Verify
        self::expectException(ClientException::class);
        self::expectExceptionCode(ClientException::INVALID_GREETING);

        // Execute
        new ParsedGreeting($greeting);
    }

    public function greetings_with_invalid_server_name()
    {
        return [
            [''],
            ["\n"],
            ['1'],
            ['tarantool'],
            ['Tarantoo'],
            ['Тарантул'],
            [str_repeat('2', 63) . "\n"],
            [str_repeat('3', 63) . "\n3"],
            [str_repeat('4', 63) . "\n\n"],
            [str_repeat('5', 63) . "\n\n\n"],
            [str_repeat('6', 63) . "\n" . str_repeat('6', 63) . "\n"],
        ];
    }

    /**
     * @test
     * @dataProvider greetings_with_invalid_salt
     */
    public function it_is_throw_on_greetings_with_invalid_salt($greeting)
    {
        // Verify
        self::expectException(ClientException::class);
        self::expectExceptionCode(ClientException::UNABLE_PARSE_GREETING);

        // Execute
        new ParsedGreeting($greeting);
    }

    public function greetings_with_invalid_salt()
    {
        return [
            [str_pad('Tarantool', 63, '1') . "\n"],
            [str_pad('Tarantool', 63, '2') . "\n2"],
            [str_pad('Tarantool', 63, '3') . "\n\n"],
            [str_pad('Tarantool', 63, '4') . "\n\n\n"],
            [str_pad('Tarantool', 63, '5') . "\nтутсолинеттутсолинеттутсолинеттутсолинеттутсолинеттутсолинеттут\n"],
        ];
    }

    /**
     * @test
     * @dataProvider valid_greetings
     */
    public function it_is_valid_greeting($greeting, $expectedSalt)
    {
        // Execute
        $parsedGreeting = new ParsedGreeting($greeting);

        [$server, $salt] = $parsedGreeting->message();

        // Verify
        self::assertStringStartsWith('Tarantool', $server);
        self::assertSame($expectedSalt, $salt);
    }

    public function valid_greetings()
    {
        return [
            [$this->generateGreeting('12345678901234567890'), '12345678901234567890'],
        ];
    }
}
