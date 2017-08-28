<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests;

use PHPUnit\Framework\TestCase;
use function Tarantool\Protocol\{
    chap_sha1,
    pack_length,
    unpack_length
};

final class FunctionsTest extends TestCase
{
    /** @test */
    public function it_packed_and_unpacked_length_correctly()
    {
        // Stub
        $value = 42;

        // Execute
        $packed = pack_length($value);
        $unpacked = unpack_length($packed);

        // Verify
        self::assertInternalType('string', $packed);
        self::assertSame($value, unpack_length($packed));
    }

    /** @test */
    public function it_returns_scramble_with_correct_length()
    {
        // Stub
        $password = 'xyz';
        $salt = \random_bytes(44);

        // Execute
        $scramble = chap_sha1($password, $salt);

        // Verify
        self::assertSame(20, \strlen($scramble));
    }
}
