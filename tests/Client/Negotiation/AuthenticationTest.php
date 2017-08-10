<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Client\Session\SingleSession;
use Tarantool\Client\{
    ClientException,
    Negotiation\Authentication,
    Negotiation\ParsedGreeting,
    Simple
};
use Tarantool\Connector;
use Tarantool\Connector\Tests\Stub\CanGenerateGreeting;

final class AuthenticationTest extends TestCase
{
    use CanGenerateGreeting;

    /** @test */
    public function it_is_authenticate_request_command_successfully()
    {
        // Stub
        $greeting = $this->generateGreeting('12345678901234567890');
        $parsedGreeting = new ParsedGreeting($greeting);

        // Mock
        $connector = self::createMock(Connector::class);

        // Verify
        $connector
            ->expects(self::once())
            ->method('sendRequest')
            ->will(self::returnValue([]));

        // Execute
        $client = new Simple($connector);
        $client->createSession(new SingleSession($parsedGreeting));

        $authenticate = new Authentication('username', 'password');
        $authenticate->negotiate($client);
    }
}
