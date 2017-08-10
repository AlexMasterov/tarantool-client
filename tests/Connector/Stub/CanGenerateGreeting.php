<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

/** @link https://github.com/tarantool-php/client/blob/master/tests/GreetingDataProvider.php */
trait CanGenerateGreeting
{
    private function generateGreeting(string $salt = null): string
    {
        $salt = $salt ?: substr(md5(uniqid()), 0, 20);

        $greeting = str_pad('Tarantool', 63, ' ') . "\n";
        $greeting .= str_pad(base64_encode($salt . str_repeat('_', 12)), 63, ' ') . "\n";

        return $greeting;
    }
}
