<?php
declare(strict_types=1);

namespace Tarantool\Client;

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#greeting-packet */
function parse_greeting(string $greeting): ?array
{
    $server = \substr($greeting, 0, 64);
    $salt = \substr(\base64_decode(\substr($greeting, 64, 44), true), 0, 20);

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
    $scramble = \sha1("{$salt}{$hash2}", true);

    return str_xor($hash1, $scramble);
}

function str_xor(string $rhash, string $lhash): string
{
    $result = '';
    for ($i = 0; $i < 20; $i += 1) {
        $result .= $rhash[$i] ^ $lhash[$i];
    }

    return $result;
}
