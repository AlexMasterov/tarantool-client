<?php
declare(strict_types=1);

namespace Tarantool\Protocol\MessagePack;

use MessagePack\{
    BufferUnpacker,
    Packer
};
use Tarantool\Protocol\{
    MessagePack,
    Request
};
use function strlen;

final class Pure implements MessagePack
{
    /** @var Packer */
    private $packer;

    /** @var BufferUnpacker */
    private $unpacker;

    public function __construct(
        Packer $packer = null,
        BufferUnpacker $bufferUnpacker = null
    ) {
        $this->packer = $packer ?? new Packer(Packer::FORCE_STR);
        $this->unpacker = $bufferUnpacker ?? new BufferUnpacker();
    }

    public function pack(Request $request): string
    {
        $data = $this->packer->packMap($request->header());
        if (!empty($request->body())) {
            $data .= $this->packer->packMap($request->body());
        }

        $length = $this->packer->packInt(strlen($data));

        return "${length}${data}";
    }

    public function unpack(string $data)
    {
        return $this->unpacker->reset($data)->unpack();
    }
}
