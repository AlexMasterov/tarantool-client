<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\Client\{
    Negotiation\Authentication,
    Simple
};
use Tarantool\{
    Client,
    ConnectorFactory
};

final class ClientFactory
{
    /** @var Connector */
    private $connector;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public static function fromString(string $dataSourceName): self
    {
        $connector = ConnectorFactory::fromString($dataSourceName)
            ->newConnector();

        return new self($connector);
    }

    public function newClient(): Client
    {
        static $negotiators = [];

        if (isset($this->username)) {
            $negotiators[] = new Authentication(
                $this->username,
                $this->password
            );
        }

        return new Simple($this->connector, $negotiators);
    }

    public function withAuthentication(
        string $username,
        string $password = null
    ): self {
        $clone = clone $this;
        $clone->username = $username;
        $clone->password = $password;

        return $clone;
    }
}
