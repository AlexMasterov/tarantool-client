<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

use function sha1;
use function substr;

/** @link https://tarantool.org/doc/1.7/dev_guide/internals_index.html#authentication */
function chap_sha1(string $password, string $salt): string
{
    static $scrambleLength = 20;

    $salt = substr($salt, 0, $scrambleLength);

    $hash1 = sha1($password, true);
    $hash2 = sha1($hash1, true);
    $hash3 = sha1("{$salt}{$hash2}", true);

    $scramble = '';
    for ($i = 0; $i < $scrambleLength; ++$i) {
        $scramble .= $hash1[$i] ^ $hash3[$i];
    }

    return $scramble;
}
