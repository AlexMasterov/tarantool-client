<?php
declare(strict_types=1);

namespace Tarantool\Protocol;

use function sha1;
use function substr;

const SCRAMBLE_LENGTH = 20;

function chap_sha1(string $password, string $salt): string
{
    $salt = substr($salt, 0, SCRAMBLE_LENGTH);

    $hash1 = sha1($password, true);
    $hash2 = sha1($hash1, true);
    $hash3 = sha1("${salt}${hash2}", true);

    $scramble = '';
    for ($i = 0; $i < SCRAMBLE_LENGTH; ++$i) {
        $scramble .= $hash1[$i] ^ $hash3[$i];
    }

    return $scramble;
}
