<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\MessagePack;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    MessagePack\CanMemoizePack,
    Request
};
use Tarantool\TestSuite\Protocol\FakeRequest;

final class MemoizePackTest extends TestCase
{
    /** @test */
    public function it_uses_memoization_request_correctly()
    {
        // Stub
        $request = new FakeRequest();
        $packer = $this->fakePacker();

        // Execute
        $result1 = $packer->pack($request);
        $count1  = $packer->count();
        $result2 = $packer->pack($request);
        $count2  = $packer->count();

        // Verify
        self::assertSame(1, $count1);
        self::assertSame(1, $count2);
        self::assertSame($result1, $result2);
    }

    private function fakePacker()
    {
        return new class() {
            use CanMemoizePack;

            /** @var int */
            private $count = 0;

            public function __construct()
            {
                $packMethod = function ($request) {
                    ++$this->count;
                    return 'result';
                };

                $this->memoizedPack = $this->memoizePack($packMethod);
            }

            public function pack(Request $request): string
            {
                return ($this->memoizedPack)($request);
            }

            public function count(): int
            {
                return $this->count;
            }
        };
    }
}
