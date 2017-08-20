<?php
declare(strict_types=1);

namespace Tarantool\Protocol\MessagePack;

use MessagePack\{
    BufferUnpacker,
    Packer as MessagePackPacker
};
use Tarantool\Protocol\{
    MessagePack,
    MessagePack\CanMemoizePack,
    MessagePack\MessagePackException,
    Request
};
use function Tarantool\Protocol\pack_length;

final class Pure implements MessagePack
{
    use CanMemoizePack;

    /** @var MessagePackPacker */
    private $packer;

    /** @var BufferUnpacker */
    private $bufferUnpacker;

    /** @var CanMemoizePack */
    private $memoizedPack;

    public function __construct(
        MessagePackPacker $packer = null,
        BufferUnpacker $bufferUnpacker = null
    ) {
        $this->packer = $packer ?? new MessagePackPacker();
        $this->bufferUnpacker = $bufferUnpacker ?? new BufferUnpacker();

        $this->memoizedPack = $this->memoizePack(function ($request) {
            $data = $this->packer->packMap($request->header());
            if (!empty($request->body())) {
                $data .= $this->packer->packMap($request->body());
            }

            $length = pack_length(\strlen($data));

            return "{$length}{$data}";
        });
    }

    public function pack(Request $request): string
    {
        return ($this->memoizedPack)($request);
    }

    public function unpack(string $data): array
    {
        $data = $this->bufferUnpacker->reset($data)
            ->tryUnpack();

        if (2 === \count($data)) {
            return $data;
        }

        throw MessagePackException::unableUnpack();
    }
}
