<?php
declare(strict_types=1);

namespace Tarantool\Client\Negotiation;

use Tarantool\Protocol\Request\Authenticate;
use Tarantool\{
    Client,
    Client\Negotiation
};
use function Tarantool\Protocol\chap_sha1;

final class Authentication implements Negotiation
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    public function __construct(
        string $username,
        string $password
    ) {
        $this->username = $username;
        $this->password = $password;
    }

    public function negotiate(Client $client): void
    {
        $session = $client->getSession();

        $tuple = ['chap-sha1', chap_sha1($this->password, $session->salt())];

        $request = new Authenticate($tuple, $this->username);

        $client->request($request);
    }
}
