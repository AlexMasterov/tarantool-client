<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\MessagePack;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\FakeRequest;
use Tarantool\Connector\{
    MessagePack\CanMemoizePack,
    Request
};

final class MemoizationTest extends TestCase
{
    /** @test */
    public function it_valid_memoize_request()
    {
        // Stub
        $request = $this->request();
        $packer = $this->packer();

        // Execute
        $result1 = $packer->pack($request);

        // Verify
        self::assertSame(1, $packer->count());

        // Execute
        $result2 = $packer->pack($request);

        // Verify
        self::assertSame(1, $packer->count());
    }

    public function packer()
    {
        return new class() {
            use CanMemoizePack;

            /** @var int */
            private $count = 0;

            public function __construct()
            {
                $this->memoizedPack = $this->memoizePack(function ($request) {
                    ++$this->count;
                    return \serialize($request);
                });
            }

            public function count(): int
            {
                return $this->count;
            }

            public function pack(Request $request): string
            {
                return ($this->memoizedPack)($request);
            }
        };
    }

    public function request(...$arguments): FakeRequest
    {
        return new FakeRequest(...$arguments);
    }
}
