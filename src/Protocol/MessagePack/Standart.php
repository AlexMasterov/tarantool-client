<?php
declare(strict_types=1);

namespace Tarantool\Protocol\MessagePack;

use MessagePack\{Decoder, Encoder};
use Tarantool\Protocol\{
    MessagePack,
    Request
};
use function strlen;

final class Standart implements MessagePack
{
    /** @var Encoder */
    private $encoder;

    /** @var Decoder */
    private $decoder;

    public function __construct(
        Encoder $encoder = null,
        Decoder $decoder = null
    ) {
        $this->encoder = $encoder ?? new Encoder();
        $this->decoder = $decoder ?? new Decoder();
    }

    public function pack(Request $request): string
    {
        $header = $this->encoder->encodeMap($request->header());
        $body = $this->encoder->encodeMap($request->body());

        $data = "${header}${body}";
        $length = $this->encoder->encodeInt(strlen($data));

        return "${length}${data}";
    }

    public function unpack(string $data)
    {
        return $this->decoder->decode($data);
    }
}
