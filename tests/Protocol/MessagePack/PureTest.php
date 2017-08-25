<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Tests\MessagePack;

use PHPUnit\Framework\TestCase;
use Tarantool\Protocol\{
    MessagePack\MessagePackException,
    MessagePack\Pure
};
use Tarantool\TestSuite\Protocol\FakeRequest;
use const Tarantool\Protocol\{
    CODE,
    DATA,
    SELECT,
    SYNC,
    UPSERT
};

/**
 * @link https://github.com/tarantool-php/client/blob/master/tests/Unit/Packer/PackerTest.php
 */
final class PureTest extends TestCase
{
    /**
     * @test
     * @dataProvider packedData
     */
    public function it_packs_the_data_correctly($header, $body, $expectedHexResult)
    {
        // Stub
        $request = new FakeRequest($header, $body);

        // Execute
        $data = (new Pure)->pack($request);

        // Verify
        self::assertSame($expectedHexResult, \bin2hex($data));
    }

    public function packedData()
    {
        return [
            [
                [
                    CODE => UPSERT,
                    SYNC => 0,
                ],
                [],
                'ce000000058200090100',
            ],
            [
                [
                    CODE => SELECT,
                    SYNC => 0,
                ],
                [],
                'ce000000058200010100',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => 1,
                ],
                [],
                'ce000000058200000101',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => 128,
                ],
                [],
                'ce0000000682000001cc80',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => 256,
                ],
                [],
                'ce0000000782000001cd0100',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => 0xffff + 1,
                ],
                [],
                'ce0000000982000001ce00010000',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => 0xffffffff + 1,
                ],
                [],
                'ce0000000d82000001cf0000000100000000',
            ],
            [
                [
                    CODE => CODE,
                    SYNC => CODE,
                ],
                [SELECT => 2],
                'ce000000088200000100810102',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider unpackedData
     */
    public function it_unpacks_data_correctly($hexData, $expectedData, $expectedSync)
    {
        // Execute
        [$header, $body] = (new Pure)
            ->unpack(\hex2bin($hexData));

        // Verify
        self::assertSame($expectedSync, $header[SYNC]);
        self::assertSame($expectedData, $body[DATA] ?? null);
    }

    public function unpackedData()
    {
        return [
            'ping()' => [
                '8200ce0000000001cf000000000000000080',
                null,
                0,
            ],
            'evaluate("return 42")' => [
                '8200ce0000000001cf00000000000000008130dd000000012a',
                [42],
                0,
            ],
            'insert(...)' => [
                '8200ce0000000001cf00000000000002168130dd0000000192ce000dbdb5aa666f6f5f393030353333',
                [[900533, 'foo_900533']],
                534,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider badUnpackedData
     */
    public function it_throw_exception_on_bad_unpacked($data)
    {
        // Verify
        self::expectException(MessagePackException::class);
        self::expectExceptionCode(MessagePackException::UNABLE_UNPACK);

        // Execute
        (new Pure)->unpack($data);
    }

    public function badUnpackedData()
    {
        return [
            ["\0"],
            ["\n"],
        ];
    }
}
