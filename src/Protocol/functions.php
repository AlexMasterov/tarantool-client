<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

use const Tarantool\Protocol\SCRAMBLE_LENGTH;

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#authentication */
function chap_sha1(string $password, string $salt): string
{
    $hash1 = \sha1($password, true);
    $hash2 = \sha1($hash1, true);
    $hash3 = \sha1("{$salt}{$hash2}", true);

    $scramble = '';
    for ($i = 0; $i < SCRAMBLE_LENGTH; ++$i) {
        $scramble .= $hash1[$i] ^ $hash3[$i];
    }

    return $scramble;
}

function pack_length(int $length): string
{
    return \pack('CN', 0xce, $length);
}

function unpack_length(string $data): int
{
    ['length' => $length] = \unpack('C/Nlength', $data);

    return $length;
}
