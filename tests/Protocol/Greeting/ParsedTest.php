<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\Greeting;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    Greeting,
    Greeting\GreetingException,
    Greeting\Parsed
};

final class ParsedTest extends TestCase
{
    /** @test */
    public function it_is_throw_on_greetings_with_invalid_size()
    {
        // Verify
        self::expectException(GreetingException::class);
        self::expectExceptionCode(GreetingException::INVALID_SIZE);

        // Mock
        $invalidSize = Greeting::SIZE - 1;
        $greeting = \random_bytes($invalidSize);

        // Execute
        new Parsed($greeting);
    }

    /** @test */
    public function it_is_throw_on_greetings_with_invalid_server_name()
    {
        // Verify
        self::expectException(GreetingException::class);
        self::expectExceptionCode(GreetingException::UNABLE_RECOGNIZE_SERVER);

        // Mock
        $greeting = $this->generateGreeting('tarantool');

        // Execute
        new Parsed($greeting);
    }

    /** @test */
    public function it_is_throw_on_greetings_with_undecoded_salt()
    {
        // Verify
        self::expectException(GreetingException::class);
        self::expectExceptionCode(GreetingException::UNABLE_DECODE_SALT);

        // Mock
        $undecodedSalt = '$VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==';
        $greeting = $this->generateGreeting('Tarantool', $undecodedSalt);

        // Execute
        new Parsed($greeting);
    }

    /**
     * @test
     * @dataProvider valid_greetings
     */
    public function it_is_valid_greeting($greeting, $expectedServer, $expectedSalt)
    {
        // Execute
        $parsedGreeting = new Parsed($greeting);

        // Verify
        self::assertSame($expectedServer, $parsedGreeting->server());
        self::assertSame($expectedSalt, $parsedGreeting->salt());
    }

    public function valid_greetings()
    {
        return [
            [
                $this->generateGreeting('Tarantool', \base64_encode('12345678901234567890')),
                'Tarantool', '12345678901234567890',
            ],
        ];
    }

    private function generateGreeting(
        string $server = null,
        string $salt = null
    ): string {
        $server = $server ?? 'Tarantool';
        $salt = $salt ?? \random_bytes(20);

        $line1 = \str_pad($server, 63, ' ');
        $line2 = \str_pad($salt, 63, ' ');
        $null = '';

        return \implode("\n", [$line1, $line2, $null]);
    }
}
