<?php
declare(strict_types=1);

namespace Tarantool\Client\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\CanGenerateGreeting;
use Tarantool\Client\{
    ClientException,
    Negotiation\ReceiveGreeting,
    Simple
};
use Tarantool\Connector;

final class ReceiveGreetingTest extends TestCase
{
    use CanGenerateGreeting;

    /** @test */
    public function it_is_create_session_successfully()
    {
        // Stub
        $salt = '12345678901234567890';
        $greeting = $this->generateGreeting($salt);

        // Mock
        $connector = self::createMock(Connector::class);
        $client = new Simple($connector);

        // Execute
        $receiveGreeting = new ReceiveGreeting($greeting);
        $receiveGreeting->negotiate($client);

        $session = $client->getSession();

        // Verify
        self::assertSame('Tarantool', $session->server());
        self::assertSame($salt, $session->salt());
    }
}
