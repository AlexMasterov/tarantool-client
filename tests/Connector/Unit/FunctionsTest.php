<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use function Tarantool\Connector\{
    pack_length,
    unpack_length
};

final class FunctionsTest extends TestCase
{
    /** @test */
    public function it_valid_packed_length()
    {
        // Stub
        $value = 42;

        // Execute
        $packed = pack_length($value);
        $unpacked = unpack_length($packed);

        // Verify
        $this->assertInternalType('string', $packed);
        $this->assertSame($value, unpack_length($packed));
    }
}
