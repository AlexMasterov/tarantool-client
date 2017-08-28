<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#authentication */
function chap_sha1(string $password, string $salt): string
{
    static $scrambleLength = 20;

    $salt = \substr($salt, 0, $scrambleLength);

    $hash1 = \sha1($password, true);
    $hash2 = \sha1($hash1, true);
    $hash3 = \sha1("{$salt}{$hash2}", true);

    $scramble = '';
    for ($i = 0; $i < $scrambleLength; ++$i) {
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
