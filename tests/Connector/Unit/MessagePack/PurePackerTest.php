<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Unit\MessagePack;

use PHPUnit\Framework\TestCase;
use Tarantool\Connector\Tests\Stub\FakeRequest;
use Tarantool\Connector\{
    MessagePack\MessagePackException,
    MessagePack\PurePacker,
    Protocol\Constants as Protocol
};

/**
 * @link https://github.com/tarantool-php/client/blob/master/tests/Unit/Packer/PackerTest.php
 */
final class PurePackerTest extends TestCase
{
    /**
     * @test
     * @dataProvider packData
     */
    public function it_valid_pack_request($header, $body, $expectedHexResult)
    {
        // Stub
        $request = $this->request($header, $body);

        // Execute
        $data = $this->packer()->pack($request);

        // Verify
        $this->assertSame($expectedHexResult, \bin2hex($data));
    }

    public function packData()
    {
        return [
            [
                [
                    Protocol::CODE => Protocol::UPSERT,
                    Protocol::SYNC => 0,
                ],
                [],
                'ce000000058200090100',
            ],
            [
                [
                    Protocol::CODE => Protocol::SELECT,
                    Protocol::SYNC => 0,
                ],
                [],
                'ce000000058200010100',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => 1,
                ],
                [],
                'ce000000058200000101',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => 128,
                ],
                [],
                'ce0000000682000001cc80',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => 256,
                ],
                [],
                'ce0000000782000001cd0100',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => 0xffff + 1,
                ],
                [],
                'ce0000000982000001ce00010000',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => 0xffffffff + 1,
                ],
                [],
                'ce0000000d82000001cf0000000100000000',
            ],
            [
                [
                    Protocol::CODE => Protocol::CODE,
                    Protocol::SYNC => Protocol::CODE,
                ],
                [Protocol::SELECT => 2],
                'ce000000088200000100810102',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider unpackData
     */
    public function it_valid_unpack_data($hexData, $expectedData, $expectedSync)
    {
        // Execute
        [$header, $body] = $this->packer()
            ->unpack(\hex2bin($hexData));

        // Verify
        $this->assertSame($expectedSync, $header[Protocol::SYNC]);
        $this->assertSame($expectedData, $body[Protocol::DATA] ?? null);
    }

    public function unpackData()
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
     * @dataProvider badUnpackData
     */
    public function it_throw_exception_on_bad_unpack_data($data)
    {
        // Verify
        self::expectException(MessagePackException::class);
        self::expectExceptionCode(MessagePackException::UNABLE_UNPACK);

        // Execute
        $this->packer()->unpack($data);
    }

    public function badUnpackData()
    {
        return [
            ["\0"],
            ["\n"],
        ];
    }

    private function packer(...$arguments): PurePacker
    {
        return new PurePacker(...$arguments);
    }

    private function request(...$arguments): FakeRequest
    {
        return new FakeRequest(...$arguments);
    }
}
