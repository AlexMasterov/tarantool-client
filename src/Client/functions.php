<?php
declare(strict_types=1);

namespace Tarantool\Client;

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#greeting-packet */
function parse_greeting(string $greeting): ?array
{
    $server = \substr($greeting, 0, 64);
    $salt = \substr(\base64_decode(\substr($greeting, 64, 44), false), 0, 20);

    if (isset($server[63], $salt[19])) {
        return [\trim($server), $salt];
    }

    return null;
}

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#authentication */
function chap_sha1(string $password, string $salt): string
{
    $hash1 = \sha1($password, true);
    $hash2 = \sha1($hash1, true);
    $hash3 = \sha1("{$salt}{$hash2}", true);

    $scramble = '';
    for ($i = 0; $i < 20; ++$i) {
        $scramble .= $hash1[$i] ^ $hash3[$i];
    }

    return $scramble;
}
