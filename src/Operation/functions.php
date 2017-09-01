<?php
declare(strict_types=1);

namespace Tarantool\Operation;

const IDENTIFIER_REGEX = '/^[a-zA-Z](?:[a-zA-Z0-9_]+)?$/';

function sql_standart_identifier(string $identifier): bool
{
    if ('*' === $identifier) {
        return true;
    }

    return (bool) \preg_match(IDENTIFIER_REGEX, $identifier);
}

// SELECT column c -> SELECT column AS c
function sql_alias(string $identifier): string
{
    $chars = \explode(' ', $identifier);

    if (!isset($chars[1])) {
        return $identifier;
    }

    static $alias = ['as' => 0, 'AS' => 1];

    foreach ($chars as $key => $char) {
        if (isset($alias[$char])) {
            unset($chars[$key]);
        }
    }

    return \implode(' AS ', $chars);
}
