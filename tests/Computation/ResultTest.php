<?php
declare(strict_types=1);

namespace Tarantool\Computation\Tests;

use PHPUnit\Framework\TestCase;
use Tarantool\Computation\{
    Result,
    Result\Failure,
    Result\Success
};
use Tarantool\TestSuite\Computation\{
    FunctorLaws,
    MonadLaws
};
use Throwable;

final class ResultTest extends TestCase
{
    /** @test */
    public function it_should_obey_monad_laws()
    {
        // Stub
        $leftOf = $this->of(6);
        $rightOf = $this->of(3);
        $map = function ($x) {
            return $x * 2;
        };

        // Execute
        $itObeys = MonadLaws::leftIdentity($leftOf, $rightOf, $map);

        // Verify
        self::assertTrue($itObeys);

        // Stub
        $leftOf = $this->of(6);
        $rightOf = $this->of(3);
        $bind = function ($x) {
            return $this->of($x * 2);
        };

        // Execute
        $itObeys = MonadLaws::rightIdentity($leftOf, $rightOf, $bind);

        // Verify
        self::assertTrue($itObeys);

        // Stub
        $of = $this->of('xyz');
        $bind = function ($x) {
            return $this->of(strlen($x));
        };
        $bind2 = function ($x) {
            return $this->of($x * 2);
        };

        // Execute
        $itObeys = MonadLaws::associativity($of, $bind, $bind2);

        // Verify
        self::assertTrue($itObeys);
    }

    /** @test */
    public function it_should_obey_functor_laws()
    {
        // Stub
        $of = $this->of(42);
        $map = function ($x) {
            return $x;
        };

        // Execute
        $itObeys = FunctorLaws::identity($of, $map);

        // Verify
        self::assertTrue($itObeys);

        // Stub
        $of = $this->of(42);
        $map = function ($x) {
            return 2 * $x;
        };
        $map2 = function ($x) {
            return $x + 1;
        };

        // Execute
        $itObeys = FunctorLaws::composition($of, $map, $map2);

        // Verify
        self::assertTrue($itObeys);
    }

    /** @test */
    public function it_returns_failure_when_exception_was_thrown()
    {
        // Stub
        $divisionByZero = function ($value) {
            return $value / 0;
        };
        $returnValue = function ($value) {
            return $value;
        };

        // Execute
        $result = $this->of(3)
            ->bind($divisionByZero)
            ->bind($returnValue)
            ->map($returnValue);

        // Verify
        self::assertFalse($result->isSuccess());
        self::assertTrue($result->isFailure());
        self::assertInstanceOf(Failure::class, $result);
        self::assertInstanceOf(Throwable::class, $result->get());
    }

    /** @test */
    public function it_returns_success_if_computation_is_successful()
    {
        // Stub
        $multiplication = function ($value) {
            return $this->of($value * 2);
        };
        $division = function ($value) {
            return $value % 3;
        };
        $returnValue = function ($value) {
            return $value;
        };

        // Execute
        $result = $this->of(3)
            ->bind($multiplication)
            ->map($division)
            ->map($returnValue);

        // Verify
        self::assertTrue($result->isSuccess());
        self::assertFalse($result->isFailure());
        self::assertInstanceOf(Success::class, $result);
        self::assertSame(0, $result->get());
    }

    /** @test */
    public function it_returns_failure_if_computation_threw_exception()
    {
        // Stub
        $divisionByZero = function ($value) {
            return $value / 0;
        };
        $returnValue = function ($value) {
            return $value;
        };

        // Execute
        $result = $this->of(3)
            ->bind($divisionByZero)
            ->bind($returnValue)
            ->map($returnValue);

        // Verify
        self::assertTrue($result->isFailure());
        self::assertFalse($result->isSuccess());
        self::assertInstanceOf(Failure::class, $result);
        self::assertInstanceOf(Throwable::class, $result->get());
    }

    private function of($x)
    {
        return Result::of($x);
    }
}
